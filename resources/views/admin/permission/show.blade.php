@extends('admin.layouts.app')

@section('headSection')
<link rel="stylesheet" href="{{asset('admin/plugins/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('main-content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
<div class="card-body pad">
     <div class="card">
            <div class="card-header">
              <h3 class="float-left">Permissions</h3>
              <a class="btn btn-success float-right" href="{{ route('permission.create') }}">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="max-width:80px" >Si No.</th>
                  <th>Permission Name</th>
                  <th>Permissions For</th>
                  <th style="max-width:80px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($permissions as $permission)
                          <tr>
                            <td style="max-width:80px">{{ $loop->index + 1 }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->for }}</td>
                              <td style="max-width:80px"><a class="" href="{{ route('permission.edit',$permission->id) }}"><i class="fa fa-edit"></i></span></a>
                                 / 
                                <form id="delete-form-{{ $permission->id }}" method="post" action="{{ route('permission.destroy',$permission->id) }}" style="display: none">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                </form>
                                <a href="" onclick="
                                if(confirm('Are you sure, You Want to delete this?'))
                                    {
                                      event.preventDefault();
                                      document.getElementById('delete-form-{{ $permission->id }}').submit();
                                    }
                                    else{
                                      event.preventDefault();
                                    }" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                              </td>
                            </tr>
                        @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('footerSection')
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
@endsection