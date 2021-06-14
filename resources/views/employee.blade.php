
<h1>Mitarbeiter</h1>
<article>
    <section>
        <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Vorname</th>
                <th scope="col">Nachname</th>
                <th scope="col">E-Mail Adresse</th>
                <th scope="col">Private E-Mail Adresse</th>
                <th scope="col">Gruppe</th>
              </tr>
            </thead>
            <tbody>
              <?php

                use app\controller\employee;
                require './app/controller/employee.controller.php';

                foreach(employee::index() as $row){
                    echo'
              <tr>
                <th scope="row">'. $row['id'] .'</th>
                <td>'. ucwords($row['first_name']) .'</td>
                <td>'. ucwords($row['last_name']) .'</td>
                <td>'. strtolower($row['email']) .'</td>
                <td>'. strtolower($row['email_2']) .'</td>
                <td>'. strtoupper($row['team']) .'</td>
              </tr>';
                  }
              ?>
            </tbody>
        </table>
    </section>
</article>