<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Services\BadgeService;

use Illuminate\Http\Request;

class BadgeController extends Controller
{   
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function getUserBadges($id)
    {
        $badges = $this->badgeService->getUserBadges($id);
        return response()->json($badges);
    }

    public function store(Request $request)
    {
        $badge = $this->badgeService->create($request->all());
        return response()->json($badge, 201);
    }

    public function update(Request $request, $id)
    {
        $badge = $this->badgeService->update($id, $request->all());
        return response()->json($badge);
    }

    public function destroy($id)
    {
        $this->badgeService->delete($id);
        return response()->json(['message' => 'Badge deleted']);
    }
}