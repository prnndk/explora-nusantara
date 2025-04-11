@php
    $color = 'bg-violet-400 text-yellow-800';

    switch ($status->value) {
        case 'approved':
            $color = 'bg-green-100 text-green-800';
            $status = 'Approved';
            break;
        case 'new_request':
            $color = 'bg-violet-100 text-violet-800';
            $status = 'New Request';
            break;
        case 'done':
            $color = 'bg-green-100 text-green-800';
            $status = 'Done';
            break;
        case 'shipping':
            $color = 'bg-teal-100 text-teal-800';
            $status = 'Shipping';
            break;
        case 'order':
            $color = 'bg-indigo-100 text-indigo-800';
            $status = 'Order';
            break;
        case 'pending':
            $color = 'bg-amber-100 text-amber-800';
            $status = 'Pending';
            break;
        case 'canceled':
            $color = 'bg-red-100 text-red-800';
            $status = 'Canceled';
            break;
        case 'rejected':
            $color = 'bg-red-100 text-red-800';
            $status = 'Rejected';
            break;
        case 'new_offer':
            $color = 'bg-purple-100 text-purple-800';
            $status = 'New Offer';
            break;
        case 'request':
            $color = 'bg-pink-100 text-pink-800';
            $status = 'Request';
            break;
        default:
            $color = 'bg-gray-100 text-gray-800';
            break;
    }
@endphp

<span class="{{ $color }} text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $status }}</span>
