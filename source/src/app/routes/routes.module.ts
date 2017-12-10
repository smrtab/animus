import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { ApartmentsComponent }  from '../apartments/apartments.component';

const routes: Routes = [
  { path: '', redirectTo: '/apartments', pathMatch: 'full' },
  { path: 'apartments', component: ApartmentsComponent }
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
