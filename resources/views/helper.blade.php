<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <form action="{{ route('helper_post')  }}" method="post" enctype="multipart/form-data" class="form">
                    @csrf                <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="file" class="form-control" accept=".csv" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <input type="submit" class="btn btn-primary float-right" value="Subir">
                            </div>
                        </div>
                    </div>
 </form>
</body>
</html>