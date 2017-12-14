import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Apartment } from '../models/apartment';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

import 'rxjs/add/operator/map';
import 'rxjs/add/observable/of';

const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json',
        'AuthToken': '78FZtsS6tvWHw4iWNrLnbZPxF4qUK1pO'
    })
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
    private deleteUrl = 'api/apartment/delete';

    constructor(private http: HttpClient) {}

    setRegistry(apartments: Apartment[]): void {
        this.__apartments = apartments;
    }

    getApartments(sync: boolean = false): Observable<Apartment[]> {

        if ((sync === false) && (this.apartments))
            return this.apartments;

        return this.http.get<Apartment[]>(this.listUrl, httpOptions).pipe(
            tap(_ => this.log('fetched apartments')),
            catchError(this.handleError<Apartment[]>('getApartments'))
        );
    }

    getApartment(id: number, sync: boolean=false): Observable<Apartment> {

        if ((sync === false) && (this.__apartments))
            return Observable.of(
                this.__apartments.find(apartment => apartment.id == id)
            );

        const url = '${this.apartmentUrl}/${id}';
        this.http.get<Apartment>(url, httpOptions).pipe(
            tap(_ => this.log('fetched apartment id=${id}')),
            catchError(this.handleError<Apartment>('getApartment id=${id}'))
        );

        return Observable.of(
            this.__apartments.find(apartment => apartment.id == id)
        );
    }

    updateApartment(apartment: Apartment): Observable<Apartment> {

        const ap: Observable<Apartment> = this.http.put<Apartment>(this.updateUrl, apartment, httpOptions).pipe(
            tap(_ => this.log('update apartment')),
            catchError(this.handleError<Apartment>('updateApartment'))
        );

        ap.subscribe(response => {
            console.log(response);
            this.dropApartment(response.id);
            this.pushApartment(response);
        });

        return ap;
    }

	addApartment(apartment: Apartment): Observable<Apartment>{
		return this.http.post<Apartment>(this.addUrl, apartment, httpOptions).pipe(
			tap(_ => this.log('add apartment')),
			catchError(this.handleError<Apartment>('updateApartment'))
		);
	}

    deleteApartment(apartment: Apartment): Observable<Apartment> {
        const id = apartment.id;
        const url = `${this.deleteUrl}/${id}`;

        const ap: Observable<Apartment> = this.http.delete<Apartment>(url, httpOptions).pipe(
            tap(_ => this.log(`deleted apartment id=${id}`)),
            catchError(this.handleError<Apartment>('deleteApartment'))
        );

        ap.subscribe(response => {
            this.dropApartment(id);
        });

        return ap;
    }

    pushApartment(apartment: Apartment): void {
        this.__apartments.push(apartment);
    }

    dropApartment(id: number): void {
        this.__apartments = this.__apartments.filter(apartment => apartment.id !== id);
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
