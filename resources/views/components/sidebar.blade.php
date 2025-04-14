<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">SimakBelajar</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SKB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item {{ isset($menudashboard) ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if ($user->role == 'admin')
                <li class="menu-header">Manajemen Data</li>
                <li class="{{ isset($menuteacher) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('teachers.index') }}"><i class="fas fa-chalkboard-user"></i>
                        <span>Data
                            Guru </span></a>
                </li>
                <li class="{{ isset($menusubject) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('subjects.index') }}"><i class="fas fa-book-open"></i> <span>Data
                            Mapel</span></a>
                </li>
                <li class="{{ isset($menuclass) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('classes.index') }}"><i class="fas fa-school"></i> <span>Data
                            Kelas</span></a>
                </li>
                <li class="{{ isset($menustudent) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('students.index') }}"><i class="fas fa-user-graduate"></i>
                        <span>Data
                            Siswa</span></a>
                </li>
                {{-- Manajemen ujian --}}
                <li class="menu-header">Manajemen Ujian</li>
                <li class="{{ isset($menuexam) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('exams.index') }}"><i class="fas fa-book"></i> <span>Data Ujian
                        </span></a>
                </li>
                <li class="{{ isset($menuquestion) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('questions.index') }}"><i class="fas fa-edit"></i> <span>Soal
                            Ujian
                        </span></a>
                </li>
                {{-- nilai --}}
                <li class="menu-header">Manajemen Nilai</li>
                <li class="{{ isset($menugrade) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('grades.index') }}"><i class="fas fa-file-pdf"></i> <span>Nilai
                            Tugas
                        </span></a>
                </li>
                <li class="{{ isset($menuexamgrade) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('grades.examIndex') }}"><i class="fas fa-file-pdf"></i>
                        <span>Nilai
                            Ujian
                        </span></a>
                </li>
                {{-- Manajemen admin --}}
                <li class="menu-header">Manajemen user</li>
                <li class="{{ isset($menuadmin) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-user"></i> <span>Data
                            Admin
                        </span></a>
                </li>
            @endif
            @if ($user->role == 'siswa')
                <li class="menu-header">Pembelajaran</li>
                <li class="{{ isset($menustudent) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('student.class') }}"><i class="fas fa-user-graduate"></i>
                        <span>Data
                            Siswa</span></a>
                </li>
                <li class="{{ isset($menusubject) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('show.subject') }}"><i class="fas fa-book-open"></i>
                        <span>Data Mapel</span></a>
                </li>
                <li class="{{ isset($menuassignment) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('show.assignment') }}">
                        <i class="fas fa-file-word"></i>
                        <span>Penugasan</span>
                    </a>
                </li>
                <li class="{{ isset($menuexam) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('exams.test') }}">
                        <i class="fas fa-chalkboard"></i>
                        <span>Ujian Online</span>
                    </a>
                </li>
                <li class="menu-header">Hasil Belajar</li>
                <li class="{{ isset($menugradeassignment) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('student.assignment') }}">
                        <i class="fas fa-file-pdf"></i>
                        <span>Nilai Tugas</span>
                    </a>
                </li>
                <li class="{{ isset($menugradeexam) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('student.exam') }}">
                        <i class="fas fa-file-pdf"></i>
                        <span>Nilai Ujian</span>
                    </a>
                </li>
            @endif
            @if ($user->role == 'guru')
                <li class="menu-header">Manajemen Data</li>
                <li class="{{ isset($menuteacher) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('show.class') }}"><i class="fas fa-school"></i>
                        <span>Data Kelas</span></a>
                </li>
                <li class="{{ isset($menumaterial) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('materials.index') }}"><i class="fas fa-book-open"></i>
                        <span>Data
                            Materi
                        </span></a>
                </li>

                <li class="menu-header">Manajemen Ujian</li>
                <li class="{{ isset($menuexam) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('exams.index') }}"><i class="fas fa-laptop-file"></i>
                        <span>Ujian Online</span></a>
                </li>
                <li class="{{ isset($menuquestion) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('questions.index') }}"><i class="fas fa-edit"></i>
                        <span>Soal Ujian</span></a>
                </li>
                <li class="{{ isset($menuassignment) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('assignments.index') }}"><i class="fas fa-file-word"></i>
                        <span>Penugasan</span></a>
                </li>

                <li class="menu-header">Manajemen Nilai</li>
                <li class="{{ isset($menugradeassignment) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('teacher.grades') }}"><i class="fas fa-file-excel"></i>
                        <span>Nilai Tugas</span></a>
                </li>
                <li class="{{ isset($menugradeexam) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('teacher.examGrades') }}"><i class="fas fa-file-excel"></i>
                        <span>Nilai Ujian</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
