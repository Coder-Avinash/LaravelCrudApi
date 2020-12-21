<table border="1">
<tr>
<th>Title</th>
<th>Description</th>
<th>Price</th>
<th>Type</th>
<th>In Stock</th>
</tr>
@foreach($products as $item)
<tr>
<td>{{$item->title}}</td>
<td>{{$item->description}}</td>
<td>{{$item->price}}</td>
<td>{{$item->type}}</td>
<td>{{$item->is_active}}</td>
</tr>
@endforeach
</table>