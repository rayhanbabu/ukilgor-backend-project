<?php
namespace App\Services\AgentService;
use Illuminate\Support\Facades\Exception;

use App\Models\Agent;

class AgentStatus
{
    public function handle($request)
    {
        $validator = validator($request->all(), [
            'id' => 'required|exists:agents,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $agent = Agent::findOrFail($request->id);
            $agent->user->status = $request->status;
            $agent->user->save();

            return response()->json([
                'message' => 'Agent status updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update agent status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
