@extends('layouts.template')

@section('content')
<div class="panel panel-default panel-service panel-transparent">
    <div class="container absolute-box-in-have-images">
      <div class="col-md-6 col-sm-6">
         <div class="wrap-box-text-contact-us">
            <div class="contact-us-title">
               <h2>{{ $block_contact_left['contact_title'] }}</h2>
               <p>{{ $block_contact_left['contact_description'] }}</p>
            </div>
            <div class="contact-us-title">
               <h2>{{ $block_contact_left['call_title'] }}</h2>
              <a href="tel:{{ $block_contact_left['call_number'] }}"><p>{{ $block_contact_left['call_number'] }}</p></a>
            </div>
            <div class="contact-us-title">
               <h2>{{ $block_contact_left['email_title']}}</h2>
              <a href="mailto:{{ $block_contact_left['email_address'] }}"><p>{{ $block_contact_left['email_address'] }}</p></a>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-6">
         <div class="box-form-contact">
            <h2>Ask the Expert</h2>
            <form name="formData" class="ng-invalid ng-invalid-required ng-valid-email ng-dirty ng-valid-parse">
               <div class="form-group">
                  <p for="">Question 1:</p>
                  <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" name="question_1" ng-model="contact.question_1" ng-required=" true" required="required">
               </div>
               <div class="form-group">
                  <p for="">Question 2:</p>
                  <input type="text" class="form-control ng-pristine ng-untouched ng-invalid ng-invalid-required" name="question_2" ng-model="contact.question_2" ng-required="true" required="required">
               </div>
              <div class="form-group">
                  <p for="">Your Email Address:</p>
                  <input type="email" class="form-control ng-pristine ng-untouched ng-valid-email ng-invalid ng-invalid-required" name="email" ng-model="contact.email" ng-required="true" required="required">
               </div>
               <div class="wrap-text-area">
                  <textarea name="message" id="" cols="30" rows="10" class="form-control ng-pristine ng-invalid ng-invalid-required ng-touched" ng-model="contact.message" ng-required="true" required="required"></textarea>
               </div>
               <br />
               <a class="btn btn-primary" id="submit-contact" ng-click="">SUBMIT</a>
            </form>
         </div>
      </div>
      <div class="clearfix"></div>
   </div>
</div>
@endsection



            