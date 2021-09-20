<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Error 404 | WIN</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
				<?php
				        $data = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2Fmovil.jpg?alt=media&token=3deeba84-de1a-4303-97ec-901accae2227");
				        $base64 = 'data:image/png;base64,' . base64_encode($data);

								$data65 = file_get_contents("https://firebasestorage.googleapis.com/v0/b/voucher-img.appspot.com/o/img_paginas%2FERROR.jpg?alt=media&token=d39016b1-8ea0-4f02-8e5b-98882d38da37");
				        $base65 = 'data:image/png;base64,' . base64_encode($data65);
				?>
        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
								background-repeat: no-repeat, repeat;
								background-size: cover;
								background-image:  url('{{$base65}}');
            }

						@media only screen and (max-width: 900px) {
						  body {
								background-image:  url('{{$base64}}');
							}
						}

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
        </style>
    </head>
    <body class="responsive-img">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
									<section class="content">
											 <div class="error-page">
												 <div class="error-content">
													 <h3><i class="fa fa-warning text-yellow"></i></h3>
												 </div>
												 <!-- /.error-content -->
											 </div>
											 <!-- /.error-page -->
									</section>
                </div>
            </div>
        </div>
    </body>
</html>
