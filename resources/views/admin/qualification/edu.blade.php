@extends('admin.layouts.master')


@section('content')

                <div class="col-lg-12 grid-margin stretch-card">

                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Education Records</h4>
                        <a href="{{ route('admin.qualification.create')}}">
                        <button type="button" class="btn btn-primary btn-fw ">Add New</button>
                        </a>
                        {{-- <p class="card-description"></code> --}}
                        </p>
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th> # </th>
                              <th> Title </th>
                              <th> Aassociation </th>
                              <th> Description </th>
                              <th> From / To </th>
                              <th> Manage </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($educations as $education)
                            <tr>
                              <td> {{ $education -> id }} </td>
                              <td>{{ $education -> title }} </td>
                              <td>
                                {{ $education -> association }}
                              </td>
                              <td>  {{ substr($education -> description,0,20)  }} ...  </td>
                              <td>  {{ $education -> from }} - {{ $education -> to }}   </td>
                              <td>
                                <a href="{{ route('admin.qualification.edit', $education->id) }}">
                                <button type="button" class="btn btn-success btn-sm">Edit</button>
                                </a>
                                <form type="submit" method="POST" action="{{ route('admin.qualification.destroy', $education->id)}}" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                            </tr>
                            <tr>

                                @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
{{--
            </div>
        </div> --}}
@endsection
