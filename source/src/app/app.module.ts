import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { HttpClientModule, HttpClient } from '@angular/common/http';

import { AppComponent } from './app.component';
import { ApartmentsComponent } from './apartments/apartments.component';
import { RoutesModule } from './routes/routes.module';
import { ApartmentService } from './services/apartment.service';


@NgModule({
  declarations: [
    AppComponent,
    ApartmentsComponent
  ],
  imports: [
    BrowserModule,
    RoutesModule,
    HttpClientModule
  ],
  providers: [ApartmentService],
  bootstrap: [AppComponent]
})
export class AppModule { }
