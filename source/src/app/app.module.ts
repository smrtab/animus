import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule,ReactiveFormsModule } from '@angular/forms';

import { HttpClientModule, HttpClient } from '@angular/common/http';

import { AppComponent } from './app.component';

import { ApartmentListComponent } from './apartment-list/apartment-list.component';
import { ApartmentShowComponent } from './apartment-show/apartment-show.component';
import { ApartmentAddComponent } from './apartment-add/apartment-add.component';

import { RoutesModule } from './routes/routes.module';

import { ApartmentService } from './services/apartment.service';
import { ApartmentEditComponent } from './apartment-edit/apartment-edit.component';


@NgModule({
  declarations: [
    AppComponent,
    ApartmentListComponent,
    ApartmentShowComponent,
    ApartmentAddComponent,
    ApartmentEditComponent
  ],
  imports: [
    BrowserModule,
    RoutesModule,
    HttpClientModule,
	FormsModule,
    ReactiveFormsModule
  ],
  providers: [
      ApartmentService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
