<?php
use app\controller\group;
$group = GROUP::index();
echo'<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-to-refresh">
        <thead>
            <tr>
                <th scope="col">
                    '.lang['alias'] .'
</th>
<th scope="col">
    '.lang['name'] .'
</th>
<th scope="col">
    '.lang['color'] .'
</th>
<th scope="col"></th>
</tr>
</thead>
<tbody>';
    foreach($group['inactive'] as $inactive){
    echo'
    <tr>
        <td>'. $inactive->alias .'</td>
        <td>'. $inactive->name .'</td>
        <td style="background-color:'. $inactive->color .';">'. $inactive->color .'</td>
        <td>
            <a href="?b=group_edit&g='. $inactive->alias .'" type="button"
                class="btn btn-sm btn-secondary position-relative">
                <i class="bi bi-gear-wide"></i>
            </a>
        </td>
    </tr>';
    }
    echo'
</tbody>
</table>
</div>';