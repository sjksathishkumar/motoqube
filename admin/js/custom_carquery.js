jQuery(function(){
	var carquery = new CarQuery();
    carquery.init();
    carquery.initYearMakeModelTrim('car-years', 'car-makes', 'car-models', 'car-model-trims');

    /*Optional: set minimum and/or maximum year options.*/
	//carquery.year_select_min=1990;
	//carquery.year_select_max=1999;
});