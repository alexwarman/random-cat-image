<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Cat Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Random Cat Image</h4>
                    </div>
                    <div class="card-body text-center">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(isset($catImage))
                            <img src="data:image/jpeg;base64,{{ $catImage }}" 
                                 alt="Random Cat" 
                                 class="img-fluid mb-3 rounded"
                                 style="max-height: 400px;">
                            
                            <div class="btn-group" role="group">
                                <a href="{{ route('cat.index') }}" class="btn btn-primary">
                                    🐱 New Cat
                                </a>
                                <a href="{{ route('cat.download') }}" class="btn btn-success">
                                    📥 Download
                                </a>
                                <form action="{{ route('cat.save') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-info">
                                        💾 Save to Storage
                                    </button>
                                </form>
                            </div>

                            <div class="mt-3">
                                <p class="text-muted small">
                                    Generated at {{ now()->format('Y-m-d H:i:s') }}
                                </p>
                            </div>
                        @else
                            <p>No cat image available.</p>
                            <a href="{{ route('cat.index') }}" class="btn btn-primary">
                                🐱 Get Random Cat
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <h5>API Endpoints</h5>
                    <div class="list-group">
                        <a href="{{ route('cat.api') }}" class="list-group-item list-group-item-action">
                            <strong>GET {{ route('cat.api') }}</strong> - JSON API
                        </a>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Artisan Commands</h5>
                    <div class="bg-dark text-light p-3 rounded">
                        <code>
                            # Get random cat (displays base64)<br>
                            php artisan cat:random<br><br>
                            # Save to file<br>
                            php artisan cat:random --save=storage/app/cat.jpg
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
