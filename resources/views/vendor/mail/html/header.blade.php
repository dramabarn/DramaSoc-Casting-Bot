<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://www.yorkdramasoc.com/wp-content/uploads/2020/07/51110306_341551310023254_3863955332002742272_n.png" class="logo" alt="Dramasoc Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
