import { Component, OnInit } from '@angular/core';
import { Observable } from "rxjs/Observable";
import { Router } from '@angular/router';
import { Apartment } from '../models/apartment';
import { ApartmentService } from '../services/apartment.service';

declare var jquery:any;
declare var $ :any;

@Component({
    selector: 'app-apartment-list',
    templateUrl: './apartment-list.component.html',
    styleUrls: ['./apartment-list.component.scss']
})
export class ApartmentListComponent implements OnInit {

    selectedApartment: Apartment;

    constructor(public apartmentService: ApartmentService,
                private router: Router) {}

    ngOnInit() {
        this.getApartments();
    }

    getApartments(): void {
        $('#spinner').show();
        this.apartmentService.getApartments(true).subscribe(ap=>{
            $('#spinner').hide();
        });
    }

    onDelete(apartment: Apartment, event: Event) {

        let service = this.apartmentService;
        let elem = event.target;

        $.confirm({
            title: 'Please cofirm!',
            content: 'You are going to delete apartment!',
            buttons: {
                confirm: function () {
                    $(elem).closest("div").html("<i class=\"fa fa-spinner fa-spin\" style=\"font-size:24px\"></i>");
                    service.deleteApartment(apartment);
                },
                cancel: function () {
                    return;
                }
            }
        });
    }

    onEdit(apartment: Apartment) {
        this.selectedApartment = apartment;
        $('#edit_appartment_modal').modal('show');
        //this.router.navigate(['/apartment/edit/', { id: apartment.id}]);
    }
}