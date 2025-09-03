<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\ApiResponseHelper;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterUserRequest;
class AuthController extends Controller
{
    //
    public function register(RegisterUserRequest $request){
        
        $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password' => Hash::make($request->password),
                "role" => $request->role,
                "status" => $request->status
        ]);

        return response()->json(['user'=>$user], 201);
    } 

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (! $token = Auth::guard('api')->attempt($credentials)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
            'timestamp' => Carbon::now()->toISOString(),
        ], 401);
    }

    $user = Auth::guard('api')->user();

    // Example permissions (in real app, fetch from DB or config)
    $permissions = [
        "canViewDashboard" => true,
        "canManageProperties" => true,
        "canManageOffice" => true,
        "canManageSecurity" => true,
        "canManageMaintenance" => true,
        "canManageUsers" => true,
        "canViewReports" => true,
        "canPropertiesSystem" => true,
        "canExportData" => true,
        "canManageGenerator" => true,
        "canManageFuel" => true,
        "canManageAddSecurity" => true,
        "canManageMembersRoutes" => true,
        "canManageMemberAttendance" => true,
        "canManageMemberDelete" => true,
        "canManageInternate" => true,
        "allowedScreens" => [
            "dashboard",
            "properties",
            "office_management",
            "security",
            "maintenance",
            "users",
            "reports",
            "settings",
            "property-systems",
            "addGenerator",
            "addFuel",
            "addSecurity",
            "membersRoutes",
            "memberAttendance",
            "memberDelete",
            "internet"
        ],
        "allowedActions" => ["create", "read", "update", "delete", "export", "import"]
    ];

    // Simulate refresh token (you can store it in DB if needed)
    $refreshToken = Auth::guard('api')->setTTL(10080)->attempt($credentials); // 7 days

    return response()->json([
        "success" => true,
        "data" => [
            "user" => [
                "id" => (string) $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone ?? null,
                "role" => $user->role ?? "SUPER_ADMIN",
                "assignedProperties" => [],
                "isActive" => $user->is_active ?? true,
                "avatar" => $user->avatar ?? null,
                "timezone" => $user->timezone ?? "Asia/Kolkata",
                "language" => $user->language ?? "en",
                "createdAt" => Carbon::parse($user->created_at)->toISOString(),
                "updatedAt" => Carbon::parse($user->updated_at)->toISOString(),
                "lastLogin" => Carbon::now()->toISOString(),
                "permissions" => $permissions
            ],
            "token" => [
                "accessToken" => $token,
                "refreshToken" => $refreshToken,
                "expiresAt" => Carbon::now()->addSeconds(Auth::guard('api')->factory()->getTTL() * 60)->toISOString(),
                "tokenType" => "Bearer"
            ],
            "message" => "Login successful"
        ],
        "timestamp" => Carbon::now()->toISOString()
    ]);
}

public function profile(){
    $user = Auth::guard('api')->user();
    return ApiResponseHelper::success($user, 'User Profile fetched successfully');
}

public function logout(){
    Auth::guard('api')->logout();
    return ApiResponseHelper::success([], 'Successfully logged out');
}

public function userlist(){
    $user = User::paginate(2);
    return ApiResponseHelper::paginated(
        $user,
        'user list fetched successfully',
        200,
        ['customNote' => 'these are active users']
    );
}

}
