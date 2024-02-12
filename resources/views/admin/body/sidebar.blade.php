@php

$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();

@endphp


<aside class="main-sidebar">
  <!-- sidebar-->
  <section class="sidebar">

    <div class="user-profile">
      <div class="ulogo">
        <a href="index.html">
          <!-- logo for regular state and mobile devices -->
          <div class="d-flex align-items-center justify-content-center">
            <h3 class="text-primary"><b>I.T.A </b>- </h3>
            @switch(Auth::user()->usertype)
            @case('Student')
            <h3><b> Espace</b> Etudiant</h3>
            @break

            @case('Admin')
            <h3><b> Espace</b> admin</h3>
            @break

            @case('Teacher')
            <h3><b> Espace</b> Enseignant</h3>
            @break

            @default
            <h3><b> Control</b> Panel</h3>
            @endswitch


          </div>
        </a>
      </div>
    </div>

    <!-- sidebar menu-->
    <ul class="sidebar-menu" data-widget="tree">

      <li class="{{ ($route == 'dashboard')?'active':'' }}">
        <a href="{{ route('dashboard') }}">
          <i data-feather="pie-chart"></i>
          <span>Tableau de Bord</span>
        </a>
      </li>


      @if(Auth::user()->usertype == 'Admin')

      <li class="treeview {{ ($prefix == '/users')?'active':'' }} ">
        <a href="#">
          <i data-feather="users"></i>
          <span>Gestion des Admins</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('user.view') }}"><i class="ti-more"></i>Liste des administrateurs</a></li>

        </ul>
      </li>
      @endif


      <li class="treeview {{ ($prefix == '/profile')?'active':'' }}">
        <a href="#">
          <i data-feather="grid"></i> <span>Gestion du Profil</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('profile.view') }}"><i class="ti-more"></i>Mon Profil</a></li>
          <li><a href="{{ route('password.view') }}"><i class="ti-more"></i>Changer Mon Mot de passe</a></li>

        </ul>
      </li>
      @if(Auth::user()->usertype == 'Student')

      @php
      $class_id = App\Models\AssignStudent::where('student_id', Auth::id())->value('class_id');
      @endphp
      <li class="header nav-small-cap">Interface de Contenus</li>
      <li class="treeview {{ ($prefix == '/students') ? 'active' : '' }}">
        <a href="#">
          <i data-feather="inbox"></i> <span>Contenus</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a target="_blank" href="{{ route('student.schedule.view', ['student_id' => Auth::id()]) }}">
              <i class="ti-more"></i> Voir l'emploi du temps
            </a>
          </li>
          <li>
            <a href="{{ route('show.studentCourses', ['student_id' => Auth::id()]) }}">
              <i class="ti-upload"></i> Support de cours
            </a>
          </li>
          <li>
            <a
              href="{{ route('student.registration.fee.payslip', ['student_id' => Auth::id(),'class_id'=>$class_id]) }}">
              <i class="ti-more"></i> Historique des paiements
            </a>
          </li>
          <li>
            <a href="{{ route('report.single.result.get', ['student_id' => Auth::id(), 'class_id' => $class_id]) }}">
              <i class="ti-more"></i>Resultat d'examen
            </a>
          </li>
        </ul>
      </li>



      @endif
      @if(Auth::user()->usertype == 'Teacher')
      <li class="header nav-small-cap">Interface de gestion des Contenus</li>
      <li class="treeview {{ ($prefix == '/teachers')?'active':'' }}">
        <a href="#">
          <i data-feather="inbox"></i> <span>Contenus</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">



          <li><a target="_blank" href="{{ route('teacher.schedule.view')}}"><i class="ti-more"></i>voir l'emploi du
              temps</a></li>

          <li>
            <a href="{{ route('show.courses') }}">
              <i class="ti-upload"></i> Support de cours
            </a>
          </li>

        </ul>

      </li>
      @endif

      @if(Auth::user()->usertype == 'Admin')

      <li class="treeview {{ ($prefix == '/setups')?'active':'' }}">
        <a href="#">
          <i data-feather="credit-card"></i> <span>Gestion des Modules</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('student.class.view') }}"><i class="ti-more"></i>Classes</a></li>
          <li><a href="{{ route('student.year.view') }}"><i class="ti-more"></i>Année Academique</a></li>
          <li><a href="{{ route('student.group.view') }}"><i class="ti-more"></i>Groupe</a></li>
          <li><a href="{{ route('school.subject.view') }}"><i class="ti-more"></i>Matières</a></li>
          <li><a href="{{ route('school.classroom.view') }}"><i class="ti-more"></i>Salle de Classe</a></li>
          <li><a href="{{ route('class.view') }}"><i class="ti-more"></i>Emploi du temps</a></li>
          <li><a href="{{ route('planning.show') }}"><i class="ti-more"></i>Planification</a></li>
          <li><a href="{{ route('module.show') }}"><i class="ti-more"></i>Modules</a></li>
          <li>
            <a href="{{ route('show.AdminCourses')}}">
              <i class="ti-upload"></i> Support de Cours
            </a>
          </li>


          <li><a href="{{ route('fee.category.view') }}"><i class="ti-more"></i>Categories de frais</a></li>
          <li><a href="{{ route('fee.amount.view') }}"><i class="ti-more"></i>Montant des Categories de frais</a></li>




        </ul>
      </li>


      <li class="treeview {{ ($prefix == '/students')?'active':'' }}">
        <a href="#">
          <i data-feather="hard-drive"></i></i> <span>Gestion des Etudiants</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('student.registration.view') }}"><i class="ti-more"></i>Liste des Etudiants</a></li>



          <li><a href="{{ route('registration.fee.view') }}"><i class="ti-more"></i>Frais d'inscription </a></li>

          <li class="{{ ($route == 'student.idcard.view')}}"><a href="{{ route('student.idcard.view') }}"><i
                class="ti-more"></i>Carte d'étudiant </a></li>







        </ul>
      </li>

      <li class="treeview {{ ($prefix == '/teachers')?'active':'' }}">
        <a href="#">
          <i data-feather="package"></i> <span>Gestion des Enseignants</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($route == 'teacher.view')?'active':'' }}"><a href="{{ route('teacher.view') }}"><i
                class="ti-more"></i>Liste des Enseignants</a></li>

          <li class="{{ ($route == 'teacher.salary.view')?'active':'' }}"><a
              href="{{ route('teacher.salary.view') }}"><i class="ti-more"></i>Salaire</a></li>

        </ul>
      </li>

      <li class="treeview {{ ($prefix == '/marks')?'active':'' }}">
        <a href="#">
          <i data-feather="edit-2"></i> <span> Gestion des notes</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ ($route == 'marks.entry.add') }}"><a href="{{ route('marks.entry.add') }}"><i
                class="ti-more"></i>Entrée de note</a></li>
          <li class="{{ ($route == 'marks.entry.edit')}}"><a href="{{ route('marks.entry.edit') }}"><i
                class="ti-more"></i>Modification de note</a></li>

          <li class="{{ ($route == 'marks.entry.grade')}}"><a href="{{ route('marks.entry.grade') }}"><i
                class="ti-more"></i>Grade de note</a></li>


        </ul>
      </li>



      <li class="treeview {{ ($prefix == '/reports')?'active':'' }}">
        <a href="#">
          <i data-feather="server"></i> <span> Gestion des Resultat</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">


          <li class="{{ ($route == 'marksheet.generate.view')}}"><a href="{{ route('marksheet.generate.view') }}"><i
                class="ti-more"></i>Generer bulletin</a></li>

          <li class="{{ ($route == 'student.result.view')}}"><a href="{{ route('student.result.view') }}"><i
                class="ti-more"></i>Resultat Etudiant </a></li>





        </ul>
      </li>







      @endif





    </ul>
  </section>

  <div class="sidebar-footer">
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings"
      aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
    <!-- item-->
    @if(Auth::user()->usertype !== 'Admin')
    <a href="mailTo:schooladmin@admin.com" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i
        class="ti-email"></i></a>
    @endif
    <!-- item-->
    <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i
        class="ti-lock"></i></a>
  </div>
</aside>