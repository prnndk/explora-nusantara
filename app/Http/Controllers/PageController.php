<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Enums\TransactionStatus;
use App\Models\Contract;
use App\Models\Product;
use App\Models\TradeMeeting;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function adminDashboard()
    {
        $contract = Contract::all();
        $meetings = TradeMeeting::all();
        $product = Product::all();
        $transaction = Transaction::with(['buyer', 'seller'])->get();

        $unvalidatedContract = $contract->where('status', ProductStatus::NEW_REQUEST)->count();
        $unvalidatedMeeting = $meetings->where('status', ProductStatus::NEW_REQUEST)->count();
        $totalMeeting = $meetings->count();
        $unvalidatedProduct = $product->where('status', ProductStatus::NEW_REQUEST)->count();

        $newestMeeting = $meetings->sortByDesc('created_at')->take(5);

        $newestTransaction = $transaction->sortByDesc('created_at')->take(5);

        // Get the last 7 months as labels (January to July in your example)
        $lastMonths = collect([]);
        for ($i = 6; $i >= 0; $i--) {
            $lastMonths->push(now()->subMonths($i)->format('F Y'));
        }

        // Group transactions by month and count them
        $transactionsByMonth = $transaction
            ->groupBy(function ($item) {
                return $item->created_at->format('F Y');
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Create the chart data structure
        $transactionChart = [
            'labels' => $lastMonths->map(fn($month) => explode(' ', $month)[0])->toArray(), // Just month names without year
            'data' => $lastMonths->map(function ($month) use ($transactionsByMonth) {
                return $transactionsByMonth[$month] ?? 0; // Return 0 if no transactions for that month
            })->toArray(),
        ];

        return view('admin.dashboard', [
            'unvalidatedContract' => $unvalidatedContract,
            'unvalidatedMeeting' => $unvalidatedMeeting,
            'totalMeeting' => $totalMeeting,
            'unvalidatedProduct' => $unvalidatedProduct,
            'newestMeeting' => $newestMeeting,
            'newestTransaction' => $newestTransaction,
            'transactionChart' => $transactionChart,
        ]);
    }
    public function sellerDashboard()
    {
        $contract = Contract::where('seller_id', Auth::user()->seller->id)->get();
        $meetings = TradeMeeting::where('seller_id', Auth::user()->seller->id)->get();
        $product = Product::where('seller_id', Auth::user()->seller->id)->get();
        $transaction = Transaction::where('seller_id', Auth::user()->seller->id)->with(['buyer', 'seller'])->get();

        $unvalidatedContract = $contract->where('status', ProductStatus::APPROVED)->count();
        $unvalidatedMeeting = $meetings->where('status', ProductStatus::APPROVED)->count();
        $unvalidatedProduct = $product->where('status', ProductStatus::NEW_REQUEST)->count();
        $ongoingTransaction = $transaction->where('status', TransactionStatus::DONE)->sum('total_harga');
        $totalMeeting = $meetings->count();
        $totalProduct = $product->count();

        $newestMeeting = $meetings->sortByDesc('created_at')->take(5);

        $newestTransaction = $transaction->sortByDesc('created_at')->take(5);

        // Get the last 7 months as labels (January to July in your example)
        $lastMonths = collect([]);
        for ($i = 6; $i >= 0; $i--) {
            $lastMonths->push(now()->subMonths($i)->format('F Y'));
        }

        // Group transactions by month and count them
        $transactionsByMonth = $transaction
            ->groupBy(function ($item) {
                return $item->created_at->format('F Y');
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Create the chart data structure
        $transactionChart = [
            'labels' => $lastMonths->map(fn($month) => explode(' ', $month)[0])->toArray(), // Just month names without year
            'data' => $lastMonths->map(function ($month) use ($transactionsByMonth) {
                return $transactionsByMonth[$month] ?? 0; // Return 0 if no transactions for that month
            })->toArray(),
        ];
        return view('seller.dashboard', [
            'unvalidatedContract' => $unvalidatedContract,
            'unvalidatedMeeting' => $unvalidatedMeeting,
            'totalMeeting' => $totalMeeting,
            'unvalidatedProduct' => $unvalidatedProduct,
            'newestMeeting' => $newestMeeting,
            'newestTransaction' => $newestTransaction,
            'transactionChart' => $transactionChart,
            'ongoingTransaction' => $ongoingTransaction,
            'totalProduct' => $totalProduct,
        ]);
    }
    public function buyerDashboard()
    {
        $contract = Contract::where('buyer_id', Auth::user()->buyer->id)->get();
        $meetings = TradeMeeting::where('buyer_id', Auth::user()->buyer->id)->get();
        $transaction = Transaction::where('buyer_id', Auth::user()->buyer->id)->with(['buyer', 'seller'])->get();

        $unvalidatedContract = $contract->where('status', ProductStatus::APPROVED)->count();
        $unvalidatedMeeting = $meetings->where('status', ProductStatus::APPROVED)->count();
        $ongoingTransaction = $transaction->where('status', TransactionStatus::NEW_REQUEST)->sum('total_harga');
        $expiredTransaction = $transaction->where('status', TransactionStatus::CANCELED)->count();
        $totalMeeting = $meetings->count();

        $newestMeeting = $meetings->sortByDesc('created_at')->take(5);

        $newestTransaction = $transaction->sortByDesc('created_at')->take(5);

        // Get the last 7 months as labels (January to July in your example)
        $lastMonths = collect([]);
        for ($i = 6; $i >= 0; $i--) {
            $lastMonths->push(now()->subMonths($i)->format('F Y'));
        }

        // Group transactions by month and count them
        $transactionsByMonth = $transaction
            ->groupBy(function ($item) {
                return $item->created_at->format('F Y');
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Create the chart data structure
        $transactionChart = [
            'labels' => $lastMonths->map(fn($month) => explode(' ', $month)[0])->toArray(), // Just month names without year
            'data' => $lastMonths->map(function ($month) use ($transactionsByMonth) {
                return $transactionsByMonth[$month] ?? 0; // Return 0 if no transactions for that month
            })->toArray(),
        ];
        return view('buyer.dashboard', [
            'unvalidatedContract' => $unvalidatedContract,
            'unvalidatedMeeting' => $unvalidatedMeeting,
            'totalMeeting' => $totalMeeting,
            'newestMeeting' => $newestMeeting,
            'newestTransaction' => $newestTransaction,
            'transactionChart' => $transactionChart,
            'ongoingTransaction' => $ongoingTransaction,
            'expiredTransaction' => $expiredTransaction,
        ]);
    }
}
