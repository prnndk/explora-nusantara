@if($is_expired)
    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
        Meeting Expired
    </span>

@elseif($status === \App\Enums\ProductStatus::APPROVED && $zoom_meeting_id)
    <a href="{{ $zoom_meeting_id }}" target="_blank"
       class="bg-violet-100 text-violet-800 text-xs font-semibold px-3 py-1 rounded-full">
       Join Now
    </a>

@elseif($status === \App\Enums\ProductStatus::REJECTED)
    <span class="bg-red-100 text-red-600 text-xs font-semibold px-3 py-1 rounded-full">
        Rejected
    </span>

@else
    <span class="bg-gray-100 text-gray-500 text-xs font-semibold px-3 py-1 rounded-full">
        Waiting Approval
    </span>
@endif