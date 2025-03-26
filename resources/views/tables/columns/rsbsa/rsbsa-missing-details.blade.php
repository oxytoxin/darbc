<div>
    @if($getRecord()->hasRsbsaRecord())

    @if($getRecord()->rsbsa->missing_details_count> 0)
    <span class="inline-flex items-center rounded-full bg-red-50   px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-gray-500/10 ring-inset">{{$getRecord()->rsbsa->missing_details_count}}</span>
    @else
    <span class="inline-flex items-center  rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">{{$getRecord()->rsbsa->missing_details_count}}</span>

    @endif

    @endif



</div>
