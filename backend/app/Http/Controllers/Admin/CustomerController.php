<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return back()->with('success', 'Customer deleted.');
    }
}
