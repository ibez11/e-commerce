@extends('layouts.app') @section('content') 
{!! $header !!}
<div class="container">
<ul class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)
    <li><a href="{{$breadcrumb['href']}}">{{ $breadcrumb['text']}}</a></li>
    @endforeach
</ul>
  <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php } ?>
  
    <div class="row">
    {!! $column_left !!}
    <div id="content" class="col-sm-9">
			<div class="row-page">
			<div class="right-side-control">
    <h1>Pesanan Kamu</h1>
    <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">No</td>
                  <td class="text-right">Invoice</td>
                  <td class="text-left">Nama</td>
                  <td class="text-right">Produk</td>
                  <td class="text-right">Total</td>
                  <td class="text-left">Tanggal Order</td>
                  <td class="text-left">Status</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
              @foreach ($orders as $order)
                <tr>
                  <td class="text-left">{{$order['nomor']}}</td>
                  <td class="text-right"><?php echo $order['invoice']; ?></td>
                  <td class="text-left"><?php echo $order['name']; ?></td>
                  <td class="text-right"><?php echo $order['products']; ?></td>
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['status']; ?></td>
                  <td class="text-right"><a href="" data-toggle="tooltip" title="" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
    </div>
    </div>
    </div>
</div>
{!! $footer !!} 
@endsection