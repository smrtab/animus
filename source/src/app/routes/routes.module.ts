import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ApartmentListComponent }  from '../apartment-list/apartment-list.component';
import { ApartmentEditComponent }  from '../apartment-edit/apartment-edit.component';

const routes: Routes = [
  { path: '', redirectTo: '/', pathMatch: 'full' },
  { path: 'apartments', component: ApartmentListComponent },
  { path: 'apartment/edit/{id}', component: ApartmentEditComponent }
];

@NgModule({
  exports: [ RouterModule ],
  imports: [
    CommonModule,
    RouterModule.forRoot(routes)
  ],
  declarations: []
})
export class RoutesModule { }
