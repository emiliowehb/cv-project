<?php

use App\Models\User;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Role;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    if (request()->is('admin*')) {
        $trail->push('Home', route('admin.dashboard'));
        return;
    }
    $trail->push('Home', route('dashboard'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Admin Dashboard', route('admin.dashboard'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('workspace-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Workspace Management', route('workspace-management.invitations.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('workspace-management.invitations.index', function (BreadcrumbTrail $trail) {
    $trail->parent('workspace-management.index');
    $trail->push('Workspace Invitations', route('workspace-management.invitations.index'));
});

// Home > Dashboard > User Management
Breadcrumbs::for('user-management.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('User Management', route('user-management.users.index'));
});

// Home > Dashboard > User Management > Users
Breadcrumbs::for('user-management.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Users', route('user-management.users.index'));
});

// Home > Dashboard > Profile > Overview
Breadcrumbs::for('dashboard.professors.my-profile.overview', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Overview', route('professors.my-profile.overview'));
});

// Home > Dashboard > Profile > Educations
Breadcrumbs::for('dashboard.professors.my-profile.educations', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Educations', route('professors.my-profile.educations'));
});

// Home > Dashboard > Profile > Languages
Breadcrumbs::for('dashboard.professors.my-profile.languages', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Languages', route('professors.my-profile.languages'));
});

// Home > Dashboard > Profile > Teaching Interests
Breadcrumbs::for('dashboard.professors.my-profile.teaching-interests', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Teaching Interests', route('professors.my-profile.teaching-interests'));
});


// Home > Dashboard > Profile > Employment History
Breadcrumbs::for('dashboard.professors.my-profile.employment-history', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Employment History', route('professors.my-profile.employment-history'));
});

// Home > Dashboard > Profile > Supervisions
Breadcrumbs::for('dashboard.professors.my-profile.graduate-supervisions', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Graduate Supervisions', route('professors.my-profile.supervisions'));
});

// Home > Dashboard > Profile > Grants
Breadcrumbs::for('dashboard.professors.my-profile.grants', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Grants', route('professors.my-profile.grants'));
});

// Home > Dashboard > Profile > Electronic Media
Breadcrumbs::for('dashboard.professors.my-profile.electronic-media', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Electronic Media', route('professors.my-profile.electronic-media'));
});

// Home > Dashboard > Profile > Interviews
Breadcrumbs::for('dashboard.professors.my-profile.interviews', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Interviews', route('professors.my-profile.interviews'));
});

// Home > Dashboard > Profile > Interviews
Breadcrumbs::for('dashboard.professors.my-profile.activities', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Activities', route('professors.my-profile.activities'));
});

// Home > Dashboard > Profile > Articles In Journals
Breadcrumbs::for('dashboard.professors.my-profile.journal-articles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Articles In Journals', route('professors.my-profile.journal-articles'));
});

// Home > Dashboard > Profile > Other Articles
Breadcrumbs::for('dashboard.professors.my-profile.other-articles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Other Articles', route('professors.my-profile.other-articles'));
});

// Home > Dashboard > Profile > Articles In Magazines
Breadcrumbs::for('dashboard.professors.my-profile.magazine-articles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Articles In Magazines', route('professors.my-profile.magazine-articles'));
});

// Home > Dashboard > Profile > Letters to Editors
Breadcrumbs::for('dashboard.professors.my-profile.lte-articles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Letters to Editors', route('professors.my-profile.lte-articles'));
});

// Home > Dashboard > Profile > Courses
Breadcrumbs::for('dashboard.professors.my-profile.courses', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Courses', route('professors.my-profile.courses'));
});

// Home > Dashboard > Profile > Articles In Magazines
Breadcrumbs::for('dashboard.professors.my-profile.cases', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Cases', route('professors.my-profile.cases'));
});

// Home > Dashboard > Profile > Newsletters
Breadcrumbs::for('dashboard.professors.my-profile.newsletter-articles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Newsletters', route('professors.my-profile.newsletter-articles'));
});

// Home > Dashboard > Profile > Books
Breadcrumbs::for('dashboard.professors.my-profile.books', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Books', route('professors.my-profile.books'));
});

// Home > Dashboard > Profile > Book Reviews
Breadcrumbs::for('dashboard.professors.my-profile.book-reviews', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Books', route('professors.my-profile.book-reviews'));
});

// Home > Dashboard > Profile > Working Papers
Breadcrumbs::for('dashboard.professors.my-profile.working-papers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Working Papers', route('professors.my-profile.working-papers'));
});

// Home > Dashboard > Profile > Chapters In Books
Breadcrumbs::for('dashboard.professors.my-profile.book-chapters', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Chapters in Books', route('professors.my-profile.book-chapters'));
});

// Home > Dashboard > Profile > Research Interests
Breadcrumbs::for('dashboard.professors.my-profile.research-interests', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Research Interests', route('professors.my-profile.research-interests'));
});

// Home > Dashboard > User Management > Users > [User]
Breadcrumbs::for('user-management.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('user-management.users.index');
    $trail->push(ucwords($user->first_name . ' ' . $user->last_name), route('user-management.users.show', $user));
});

// Home > Dashboard > User Management > Roles
Breadcrumbs::for('user-management.roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Roles', route('user-management.roles.index'));
});

// Home > Dashboard > User Management > Roles > [Role]
Breadcrumbs::for('user-management.roles.show', function (BreadcrumbTrail $trail, Role $role) {
    $trail->parent('user-management.roles.index');
    $trail->push(ucwords($role->name), route('user-management.roles.show', $role));
});

// Home > Dashboard > User Management > Permission
Breadcrumbs::for('user-management.permissions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('user-management.index');
    $trail->push('Permissions', route('user-management.permissions.index'));
});
