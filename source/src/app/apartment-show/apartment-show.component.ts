import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs/Observable';
import { ActivatedRoute } from '@angular/router';
import { Apartment } from '../models/apartment';
import { ApartmentService } from '../services/apartment.service';

@Component({
  selector: 'app-apartment-show',
  templateUrl: './apartment-show.component.html',
  styleUrls: ['./apartment-show.component.scss']
})
export class ApartmentShowComponent implements OnInit {

  id: number;
  apartment: Observable<Apartment>;

  constructor(private route: ActivatedRoute,
              private apartmentService: ApartmentService) { }

  ngOnInit() {
      this.route.params.subscribe(params => {
          console.log(params);
          console.log(params['id']);

          this.id = +params['id'];
          this.apartment = this.apartmentService.getApartment(this.id);

      });
  }

}
