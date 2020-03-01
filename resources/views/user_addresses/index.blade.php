@extends('layouts.app')
@section('title','收货地址列表')

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card panel-default">
                <div class="card-header">
                    收货地址列表
                    <a href="{{ route('user_address.create') }}" class="float-right">新增收货地址</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>收货人</th>
                            <th>地址</th>
                            <th>邮编</th>
                            <th>联系电话</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($addresses as $address)
                            <tr>
                                <td>{{$address->contact_name}}</td>
                                <td>{{$address->full_address}}</td>
                                <td>{{$address->zip}}</td>
                                <td>{{$address->contact_phone}}</td>
                                <td>
                                    <a href="{{ route('user_address.edit',['user_address'=>$address->id]) }}"
                                       class="btn btn-primary">修改</a>
                                    <button type="button" class="btn btn-danger btn-del-address"
                                            data-id="{{ $address->id }}">删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scriptAfterJs')
    <script>
        $(document).ready(function () {
            $('.btn-del-address').click(function () {
                var id = $(this).data('id');

                swal({
                    title: "确认要删除改地址？",
                    icon: "warning",
                    buttons: ['取消', '确定'],
                    dangerMode: true,
                }).then(function (willDelete) {
                    if (!willDelete) {
                        return;
                    }
                    // 调用删除接口，用 id 来拼接出请求的 url
                    axios.delete('/user_address/' + id).then(function () {
                        // 请求成功之后重新加载页面
                        location.reload();
                    })
                });
            });
        });
    </script>
@endsection
