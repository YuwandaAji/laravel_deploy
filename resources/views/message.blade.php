<style type="text/css">
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    border: 1px solid transparent;
}

.alert h4 {
    margin-top: 0;
    color: inherit;
}

.alert .alert-link {
    font-weight: bold;
}

.alert p, ul {
    margin-bottom: 0;
}

.alert p + p {
    margin-top: 5px;
}

.alert-dismissable .close {
    position: relative
    top: -2px;
    right: -21px;
    color:inherit;
}

.alert-success hr {
  border-top-color: #c9e2b3;
}

.alert-success .alert-link {
  color: #2b542c;
}

.alert-info {
  background-color: #d9edf7;
  border-color: #bce8f1;
  color: #31708f;
}

.alert-info hr {
  border-top-color: #a6e1ec;
}

.alert-info .alert-link {
  color: #245269;
}

.alert-warning {
  background-color: #fcf8e3;
  border-color: #faebcc;
  color: #8a6d3b;
}

.alert-warning hr {
  border-top-color: #f7e1b5;
}

.alert-warning .alert-link {
  color: #66512c;
}

.alert-danger {
  background-color: #f2dede;
  border-color: #ebcccd1;
  color: #a94442;
}

.alert-danger hr {
  border-top-color: #e4b9c0;
}

.alert-danger .alert-link{
  border-top-color: #e4b9c0;
}
</style>


@if(!empty(session('succes')))
    <div class="alert alert-succes" role="alert">
        {{ session('succes') }}
    </div>
@endif

@if(!empty(session('error')))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif