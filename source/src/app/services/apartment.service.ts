import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Apartment } from '../models/apartment';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class ApartmentService {

  private url = 'api/apartments';
  private addUrl = 'api/apartment/add';

  constructor(private http: HttpClient) {}

  getApartments(): Observable<Apartment[]> {
    return this.http.get<Apartment[]>(this.url).pipe(
        tap(_ => this.log('fetched apartments')),
        catchError(this.handleError<Apartment[]>('getApartments'))
    );
  }

  getApartment(id: number): Observable<Apartment> {
    const url = '${this.url}/${id}';
    return this.http.get<Apartment>(url).pipe(
        tap(_ => this.log('fetched apartment id=${id}')),
        catchError(this.handleError<Apartment>('getApartment id=${id}'))
    );
  }

  updateApartment(apartment: Apartment): Observable<any> {
    return this.http.put(this.url, apartment, httpOptions).pipe(
        tap(_ => this.log('updated apartment id=${apartment.id}')),
        catchError(this.handleError<any>('updateApartment'))
    );
  }

  addApartment(apartment: Apartment): Observable<Apartment> {
    return this.http.post<Apartment>(this.addUrl, apartment, httpOptions).pipe(
        tap(_ => this.log('add apartment')),
        catchError(this.handleError<Apartment>('updateApartment'))
    );
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
