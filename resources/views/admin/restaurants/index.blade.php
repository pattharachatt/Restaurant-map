@extends('layouts.admin')
@section('content')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("admin.restaurants.create") }}">
            {{'Add Restaurants'}}
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
       {{'Restaurants List'}}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Restaurants">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ 'Id' }}
                        </th>
                        <th>
                            {{ 'Name' }}
                        </th>
                        <th>
                            {{ 'Category' }}
                        </th>
                        <th>
                            {{ 'Address' }}
                        </th>
                        <th>
                            {{ 'Active' }}
                        </th>
                        <th>
                            {{ 'Action' }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurants as $key => $restaurant)
                        <tr data-entry-id="{{ $restaurant->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $restaurant->id ?? '' }}
                            </td>
                            <td>
                                {{ $restaurant->name ?? '' }}
                            </td>
                            <td>
                                @foreach($restaurant->categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $restaurant->address ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $restaurant->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $restaurant->active ? 'checked' : '' }}>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.restaurants.show', $restaurant->id) }}">
                                    {{ 'View' }}
                                </a>

                                <a class="btn btn-xs btn-info" href="{{ route('admin.restaurants.edit', $restaurant->id) }}">
                                    {{ 'Edit' }}
                                </a>

                                <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ 'Delete' }}">
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = 'Delete'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.restaurants.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('Are you sure?')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Restaurants:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection