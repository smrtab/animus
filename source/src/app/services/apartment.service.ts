import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Apartment } from '../apartments/apartment';

@Injectable()
export class ApartmentService {

  private url = 'api/apartments';

  constructor(private http: HttpClient) {}

  getApartments(): Observable<Apartment[]> {
    return this.http.get<Apartment[]>(this.url);
  }

}
