@php
    $color = 'bg-violet-400 text-yellow-800';

    switch ($status) {
        case 'approved':
            $color = 'bg-green-100 text-green-800';
            $status = 'Approved';
            break;
        case 'new_request':
            $color = 'bg-violet-100 text-violet-800';
            $status = 'New Request';
            break;
        case 'rejected':
            $color = 'bg-red-100 text-red-800';
            $status = 'Rejected';
            break;
        case 'pending':
            $color = 'bg-amber-100 text-amber-800';
            $status = 'Pending';
            break;
        default:
            $color = 'bg-gray-100 text-gray-800';
            break;
    }
@endphp

<span class="{{ $color }} text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $status }}</span>