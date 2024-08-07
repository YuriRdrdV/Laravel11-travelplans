<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Models\TravelPlan;
use Validator;
use App\Http\Resources\TravelPlanResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TravelPlanController extends APIController
{
    /**
     * Mostrar todos os registros do usuário autenticado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $TravelPlans = TravelPlan::where('user_id', $userId)->get();
        return $this->sendResponse(TravelPlanResource::collection($TravelPlans), 'Planos de viagem retornados com sucesso.');
    }
    /**
     * Salvar um novo registro em banco.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required|date',
            'location' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $input = $request->all();
        $input['user_id'] = $userId;
        $TravelPlan = TravelPlan::create($input);
        return $this->sendResponse(new TravelPlanResource($TravelPlan), 'Plano de viagem criado com sucesso.');
    }

   
    /**
     * Mostrar registro especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $TravelPlan = TravelPlan::find($id);
        if (is_null($TravelPlan)) {
            return $this->sendError('Plano de viagem não encontrado.');
        }
        $userId = Auth::id();
        if ($TravelPlan->user_id !== $userId) {
            return $this->sendError('Você não tem permissão para acessar este plano de viagem.', [], 403);
        }
        return $this->sendResponse(new TravelPlanResource($TravelPlan), 'Plano de viagem recuperado com sucesso.');
    }
    
    /**
     * Atualizar registro de plano repassado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $userId = Auth::id();
        $travelPlan = TravelPlan::find($id);
        if (is_null($travelPlan) || $travelPlan->user_id !== $userId) {
            return $this->sendError('Você não tem permissão para acessar ou modificar este plano de viagem.', [], 403);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'location' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $data = $request->only(['title', 'description', 'date', 'location']);
        $travelPlan->fill($data);
        $travelPlan->save();

        return $this->sendResponse(new TravelPlanResource($travelPlan->fresh()), 'Plano de viagem alterado com sucesso.');
    }
   
    /**
     * Remoção de registro do plano de viagem.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): JsonResponse
    {
        $TravelPlan = TravelPlan::find($id);
        if (is_null($TravelPlan)) {
            return $this->sendError('Plano de viagem não encontrado.');
        }
        $userId = Auth::id();
        if ($TravelPlan->user_id !== $userId) {
            return $this->sendError('Você não tem permissão para acessar este plano de viagem.', [], 403);
        }else{
            $TravelPlan->delete();
            return $this->sendResponse([], 'Plano de viagem deletado com sucesso.');
        }
    }
}
