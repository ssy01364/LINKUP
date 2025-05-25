{{-- resources/views/partials/alerts.blade.php --}}

@foreach (['success', 'error', 'warning', 'info', 'status'] as $msg)
  @if(session($msg))
    @php
      // Bootstrap alert classes: map Laravel keys to Bootstrap
      $bootstrapClass = match($msg) {
        'error'   => 'danger',
        'warning' => 'warning',
        'info'    => 'info',
        default   => 'success',
      };
    @endphp
    <div class="alert alert-{{ $bootstrapClass }} alert-dismissible fade show" role="alert">
      {{ session($msg) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
  @endif
@endforeach

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
