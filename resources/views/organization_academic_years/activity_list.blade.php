<div class="table-responsive">
    <table width="100%" class="table table-striped table-bordered table-hover datatable" >
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Activity Title</th>
                <th>Nature of Activity</th>
                <th>Requestor</th>
                
                <th>
                    Option
                </th>
                
            </tr>
        </thead>
        <tbody>
            <?php $i=1; ?>
            @foreach($activity as $activity)
            <tr>
                <td>{{ $i++ }}</td>
                <td><?php echo \Carbon\Carbon::createFromFormat('Y-m-d', $activity->date)->format('M-d-Y'); ?></td>
                <td>{{ $activity->title }}</td>
                <td>{{ $activity->nature }}</td>
                <td>{{ $activity->fname}} {{ $activity->lname}}</td>
                
                <td>
                    <form action="{{route('activities.destroy', $activity->id)}}" method="POST">      
                        <input type="hidden" name="_method" value="delete">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="{{route('activities.view_content', $activity->id)}}" class="btn btn-xs btn-info btn-rounded"><i class="fa fa-eye"></i>View</a>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>