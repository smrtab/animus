import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Apartment } from '../models/apartment';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

import 'rxjs/add/operator/map';
import 'rxjs/add/observable/of';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class ApartmentService {

  //REGISTRY
  private __apartments: Apartment[];

  get apartments(): Observable<Apartment[]> {
      return Observable.of(this.__apartments);
  }

    //URLS
  private listUrl = 'api/apartments';
  private addUrl = 'api/apartment/add';
  private updateUrl = 'api/apartment/update';
  private apartmentUrl = 'api/apartment';

  constructor(private http: HttpClient) {}

  getApartments(sync: boolean = false): Observable<Apartment[]> {

    if ((sync === false) && (this.apartments))
        return this.apartments;

    this.http.get<Apartment[]>(this.listUrl).pipe(
        tap(_ => this.log('fetched apartments')),
        catchError(this.handleError<Apartment[]>('getApartments'))
    ).subscribe(apartment => this.__apartments = apartment);

    return this.apartments;
  }

  getApartment(id: number, sync: boolean=false): Apartment {

    if ((sync === false) && (this.apartments))
        return this.__apartments.find(apartment => apartment.id == id);

    const url = '${this.apartmentUrl}/${id}';
    this.http.get<Apartment>(url).pipe(
        tap(_ => this.log('fetched apartment id=${id}')),
        catchError(this.handleError<Apartment>('getApartment id=${id}'))
    );
  }

  updateApartment(apartment: Apartment): Observable<any> {
    return this.http.put(this.updateUrl, apartment, httpOptions).pipe(
        tap(_ => this.log('updated apartment id=${apartment.id}')),
        catchError(this.handleError<any>('updateApartment'))
    );
  }

    addApartment(apartment: Apartment): Observable<Apartment>{
        const ap: Observable<Apartment> = this.http.post<Apartment>(this.addUrl, apartment, httpOptions).pipe(
            tap(_ => this.log('add apartment')),
            catchError(this.handleError<Apartment>('updateApartment'))
        );

        ap.subscribe(response => {
            console.log(response);
            this.pushApartment(response);
        });

        return ap;
    }

  pushApartment(apartment: Apartment): void {
      this.log(JSON.stringify(apartment));
      this.__apartments.push(apartment);
  }

  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      this.log('${operation} failed: ${error.message}');

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  private log(message: string) {
    console.log('ApartmentService: ' + message);
  }

}
