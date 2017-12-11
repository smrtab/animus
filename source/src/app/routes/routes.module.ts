import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ApartmentListComponent }  from '../apartment-list/apartment-list.component';
import { ApartmentShowComponent }  from '../apartment-show/apartment-show.component';

const routes: Routes = [
  { path: '', redirectTo: '/', pathMatch: 'full' },
  { path: 'apartments', component: ApartmentListComponent },
  { path: 'apartment/show', component: ApartmentShowComponent }
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
