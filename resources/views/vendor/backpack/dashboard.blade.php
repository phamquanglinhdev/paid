@extends(backpack_view("blank"))
@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-primary">
                    <div class="card-body">
                        <div class="text-value">{{$_student_count??0}}</div>

                        <div>Học sinh</div>
                    </div>

                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-success">
                    <div class="card-body">
                        <div class="text-value">{{$_activate_bill_count??0}}</div>

                        <div>Hóa đơn còn hạn</div>
                    </div>

                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-warning">
                    <div class="card-body">
                        <div class="text-value">{{$_remaining_count??0}}</div>

                        <div>Hóa đơn sắp hết hạn</div>
                    </div>

                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-dark">
                    <div class="card-body">
                        <div class="text-value">{{$_deactivate_bill_count??0}}</div>

                        <div>Hóa đơn hết hạn (hoặc đã xóa)</div>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-cyan">
                    <div class="card-body">
                        <div class="text-value">{{number_format($_total??0)}} đ</div>

                        <div>Tổng thu</div>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-behance">
                    <div class="card-body">
                        <div class="text-value">{{number_format($_total_in_month??0)}} đ</div>

                        <div>Tổng thu trong tháng này</div>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-dribbble">
                    <div class="card-body">
                        <div class="text-value">{{number_format($_total_in_last_month??0)}} đ</div>

                        <div>Tổng thu trong tháng trước</div>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 text-white bg-blue">
                    <div class="card-body">
                        <div class="text-value">{{round(($_total_in_month/$_total_in_last_month)*100)}} %</div>
                        <small>Tăng trưởng</small>
                        <small>( tính đến {{\Carbon\Carbon::now()->isoFormat("DD-MM-YYYY")}})</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mb-5">
        <div class="h2">Hóa đơn cần gia hạn !</div>
        <div class="small mb-2">Chọn và xóa hóa đơn cũ khi đã tạo hóa đơn mới !</div>
        @foreach($_remaining as $bill)
            <div class="bg-danger p-2 rounded justify-content-between d-flex align-items-center my-2">
                <div>
                    <div>
                        <i class="las la-user"></i>
                        Học sinh : {{$bill->student->name}}.
                    </div>
                    <div>
                        <i class="las la-calendar"></i>
                        Ngày hết hạn : {{date("d-m-Y",strtotime($bill->end))}}
                    </div>
                </div>
                <div>
                    <form action="{{route("bill.destroy",$bill->id)}}" method="post">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn  rounded">
                            <i class="lar la-2x text-white la-check-circle"></i>
                        </button>
                    </form>
                </div>
            </div>

        @endforeach
    </div>
@endsection
