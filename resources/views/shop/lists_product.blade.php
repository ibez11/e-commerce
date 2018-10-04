@extends('layouts.app')
@section('content')
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
	<div class="pull-right btn-back">       
		 
	  </div>
        
	<h1>Daftar Produk</h1>
       <div class="panel-body panel-product">
        <div class="well">
          <div class="row">
            <div class="col-md-6">
            </div>
        </div>
        <div class="mb-20">
            <a href="{{route('add_product')}}" data-toggle="tooltip" title="Tambah" class="btn btn-link btn-lg btn-block"><i class="fa fa-plus"></i></a>
        </div>
        <form action="delete" method="post" enctype="multipart/form-data" id="form-product">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center"><b>Gambar</b></td>
                  <td class="text-left"><b>Nama Produk<b></td>
                  
                  <td class="text-right"><b>Harga</b></td>
                  <td class="text-right"><b>Kuantiti</b></td>
                  <td class="text-left"><b>Status</b></td>
		            <td class="text-right"><b>Aksi</b></td>
                </tr>
              </thead>
              <tbody>
                @if ($products)
                @foreach ($products as $product)
                <tr>
                  <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-center"><?php if ($product['image']) { ?>
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><a href="{{$product['product_page']}}" target="_blank"><?php echo $product['name']; ?></a></td>
                  <td class="text-right">{{$product['price']}}</td>
                  <td class="text-right"><?php if ($product['quantity'] <= 0) { ?>
                    <span class="label label-warning">{{$product['quantity']}}</span>
                    <?php } elseif ($product['quantity'] <= 5) { ?>
                    <span class="label label-danger">{{$product['quantity']}}</span>
                    <?php } else { ?>
                    <span class="label label-success">{{$product['quantity']}}</span>
                    <?php } ?></td>
		  <?php //if($isgoldMember){ ?>
                  <td class="text-right">{{$product['status']}}
                  </td>
		  <?php //} ?> 
                  <td class="text-right"><a href="{{route('edit_product',['_id' =>  $product['product_id']])}}" data-toggle="tooltip" title="Ubah" class="btn btn-link"><i class="fa fa-pencil"></i></a></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class="text-center" colspan="9">Produk belum ada</td> 
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </form>
      </div>
      </div>
     </div>
     </div> 
     </div>
     </div> 
     </div>
     {!! $footer !!}
@endsection