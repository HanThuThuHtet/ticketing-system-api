<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketCreateRequest;
use App\Http\Resources\TicketResource;
use App\Models\Queue;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class TicketApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tickets = Ticket::all();
        $tickets = Ticket::latest("id")->paginate(8);
        return TicketResource::collection($tickets);
 
    }


    public function all(Request $request)
    {
        $perPage = $request->input('perPage', 8); 
        $page = $request->input('page',1);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $tickets = Ticket::latest("id")->paginate($perPage);
        return TicketResource::collection($tickets);  
        
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $perPage = $request->input('perPage', 8); 
        $page = $request->input('page');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $tickets = Ticket::when($searchTerm, function (Builder $query, $searchTerm) {
            $query->where('id', '=', $searchTerm);
        })
        ->latest("id")
        ->paginate($perPage);

        return TicketResource::collection($tickets);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketCreateRequest $request)
    {
        $data = $request->validated();
        
        $ticket = Ticket::create([
            "subject" => $data["subject"],
            "description" => $data["description"],
            "status_id" => $data["status_id"],
            "customer_id" => $data["customer_id"],
            "queue_id" => $data["queue_id"],
            "user_id" => Auth::id()
        ]);
        //return response()->json($ticket->user_id);

        // $queue = Queue::find($data['queue_id']);
        // $ticket->queue()->associate($queue);
        // $ticket->save();

        $queue = Queue::find($data['queue_id']);
        $ticket->queue()->associate($queue);
        // Auth::user()->queues()->sync($queue);
        
        return response()->json([
            "message" => "Ticket Created",
            "success" => true,
            "ticket" => new TicketResource($ticket)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        if(is_null($ticket)){
            return response()->json(["message" => "Ticket is not found"],404);
        }
        //return response()->json($ticket);

        $this->authorize('view',$ticket);

        return new TicketResource($ticket);

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "subject" => "sometimes|max:20",
            "description" => "sometimes|max:100",
            "status_id" => "sometimes|exists:statuses,id",
            "customer_id" => "sometimes|exists:customers,id",
            "queue_id" => "sometimes|exists:queues,id"
        ]);
        
        $ticket = Ticket::find($id);
        if(is_null($ticket)){
            return response()->json(["message" => "Ticket is not found"],404);
        }

        $this->authorize('update',$ticket);

        $ticket->fill($request->only(['subject', 'description', 'status_id', 'customer_id','queue_id']));
        
       
        $ticket->save();

        // $newQueue = Queue::find($request['queue_id']);
        // Auth::user()->queues()->attach($newQueue);

        
        //return response()->json($ticket);
        return response()->json([
            "message" => "Ticket Updated",
            "success" => true,
            "ticket" => new TicketResource($ticket)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if(is_null($ticket)){
            return response()->json(["message" => "Ticket is not found"],404);
        }
        $ticket->delete();
        return response()->json(["message" => "Ticket is Deleted"],204);
    }
}
