import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Apartment } from '../models/apartment';
import { ApartmentService } from '../services/apartment.service';
import {Observable} from "rxjs/Observable";

declare var jquery:any;
declare var $ :any;

@Component({
  selector: 'app-apartment-list',
  templateUrl: './apartment-list.component.html',
  styleUrls: ['./apartment-list.component.scss']
})
export class ApartmentListComponent implements OnInit {

    constructor(public apartmentService: ApartmentService,
                private router: Router) {}

    ngOnInit() {
        this.getApartments();
    }

    getApartments(): void {
        this.apartmentService.getApartments(true);
    }

    onSelect(apartment: Apartment): void {
        $('#show_appartment_modal').modal('show');
    }

    onDelete(apartment: Apartment) {

        const apartmentService = this.apartmentService;

        $.confirm({
            title: 'Please cofirm!',
            content: 'You are going to delete apartment!',
            buttons: {
                confirm: function () {
                    apartmentService.deleteApartment(apartment);
                },
                cancel: function () {
                    return;
                }
            }
        });


    }
}
