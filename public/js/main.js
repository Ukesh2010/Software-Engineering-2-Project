
var smartAdd = false;
$('#logoutBtn').click(function () {
    window.location.href = "logout.php";
});
$('#manualAdd').click(function () {
    window.location.href = "AddBooks.php";
});
$('#accessCatalog').click(function () {
    window.location.href = "booksList.php";
});

$('#swiftAdd').click(function () {
    $('#isbnModal').modal('show');
});

$("#publisherSelect").bind('keyup', function () {
    if ($(this).val() == undefined || $(this).val() == '') {
        return;
    }
    var url = "getAutocomplete.php?type=publisher";
    var type = "POST";
    var data = 'keyword=' + $(this).val();
    var async = true;
    handleAjaxCall(url, type, data, async, function (data) {

        var datas = JSON.parse(data);

        var tempHtml = '';
        if (datas === 'false' || datas[0] == undefined) {
            tempHtml = '<ul id="publisherli" ><li onclick="selectObject(\'\',\'publisherSelect\',\' \');"><i>No data found.</i></li></ul>';
        } else {
            tempHtml = '<ul id="publisherli">'
            tempHtml += '<li onclick="selectObject(\' \',\'publisherSelect\',\'\');"><i>(none)</i></li>';
            for (var i = 0; i < datas.length; i++) {
                var wholeData = datas[i].split('_');
                var id = wholeData[0];
                var name = wholeData[1];
                tempHtml += '<li onclick="selectObject(this,\'publisherSelect\',' + id + ');">' + name + '</li>';
            }
            tempHtml += '</ul>';
        }
        $("#publishDropdown").html(tempHtml);
        $("#publishDropdown").show();
    }, errorCallBack, false);
});
$("#authorSelect").bind('keyup', function () {
    if ($(this).val() == undefined || $(this).val() == '') {
        return;
    }
    var url = "getAutocomplete.php?type=author";
    var type = "POST";
    var data = 'keyword=' + $(this).val();
    var async = true;
    handleAjaxCall(url, type, data, async, function (data) {
        var datas = JSON.parse(data);
        var tempHtml = '';
        if (datas === 'false' || datas[0] == undefined) {
            tempHtml = '<ul id="authorli" ><li onclick="selectObject(\' \',\'authorSelect\',\'\');"><i>No data found.</i></li></ul>';
        } else {
            tempHtml = '<ul id="authorli">'
            tempHtml += '<li onclick="selectObject(\' \',\'authorSelect\',\'\');"><i>(none)</i></li>';
            for (var i = 0; i < datas.length; i++) {
                var wholeData = datas[i].split("_");
                var authorName = wholeData[0];
                var id = wholeData[1];
                tempHtml += '<li onclick="selectObject(this,\'authorSelect\',' + id + ');">' + authorName + '</li>';
            }
            tempHtml += '</ul>';
        }
        $("#authorDropdown").html(tempHtml);
        $("#authorDropdown").show();
    }, errorCallBack, false);
});
function selectObject(obj, item, id) {

    $('#authorSelect , #publisherSelect').unbind('blur');
    var value = $(obj).text();
    if (item == 'authorSelect') {
        $('#inputAuthorID').val(id);
    } else {
        $('#inputPublishID').val(id);
    }
    $("#" + item).val(value);
    $("#authorDropdown").html('');
    $("#publishDropdown").html('');
    $("#publishDropdown").hide();
    $("#authorDropdown").hide();
    setTimeout(function () {
        $('#authorSelect , #publisherSelect').bind('blur', callthisfunction);
    }, 100);
}

$("#imgInp").change(function () {
    readURL(this);
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#bookCover').attr('src', e.target.result);
            $('#imageSource').attr('value', '');
        }

        reader.readAsDataURL(input.files[0]);
    }
}


function handleBookSubmit(form, value, bookID) {
    blockUI();
    var data = new FormData(form);
    data.append('type', value);
    data.append('bookID', bookID);
    var url = "uploadBookInfo.php";
    var type = "POST";
    var async = true;
    $.ajax({
        url: url,
        type: type,
        data: data,
        async: async,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            result = result.trim();
            if (result == 'true') {
                alert('Operation Successful.');
                window.location.href = 'booksList.php';
            } else if (result == 'false') {
                alert('Error adding book.');
            } else if (result == 'exists') {
                alert('Book already exists in database.');

            } else {
                alert(result);

            }
        },
        error: function () {
            $.unblockUI();
            smartAdd = false;
        }, complete: function () {
            $.unblockUI();
            smartAdd = false;
        }
    });

}


function doLogin() {
    var returnVal = false;
    var data = $('#loginForm').serialize();
    handleAjaxCall('login.php', 'POST', data, false, function (result) {
        if (result == 'true') {
            returnVal = true;
        } else if (result == 'inactive') {
            addAlert("User status inactive.");
            returnVal = false;
        } else {
            returnVal = false;
            addAlert("Invalid username or password.");
        }
    }, errorCallBack);
    return returnVal;
}


$('#authorSelect,#publisherSelect').bind('blur', callthisfunction);
function callthisfunction(obj) {
    setTimeout(function () {
        if (!smartAdd) {
            if (obj.target !== undefined) {
                var id = obj.target.id;
                var did = $('#' + id).next().attr('id');
                if (did == 'authorSelect-error' || did == 'publisherSelect-error') {
                    did = $('#' + id).next().next().attr('id');
                }
                var val = $('#' + id).val();
                var types = '';
                var classes = $('#' + id).next().attr('class');
                if (classes == 'error') {
                    classes = $('#' + id).next().next().attr('class');
                }
                if (val == undefined || val == '') {
                    return;
                }
                if (id == 'publisherSelect') {
                    types = 'checkPublisher';
                } else if (id == 'authorSelect') {
                    types = 'checkAuthor';
                } else {
                    types = '';
                }
                var url = 'getAutoComplete.php?type=' + types;
                var data = 'keyword=' + sanitize(val);
                var type = 'POST';
                var async = 'true';
                handleAjaxCall(url, type, data, async, function (rs) {
                    if (rs == 'true') {
                        $('.' + classes).css('display', 'none');
                    } else {
                        $('#' + id).val('');
                        $('.' + classes).css('display', 'none');
                    }
                }, errorCallBack);
            }
        }
    }, 1000);
}


$('#btnAddAuthor').click(function () {
    var authorFirstName = sanitize($('#addAuthorModal #authorFirstName').val());
    var authorLastName = sanitize($('#addAuthorModal #authorLastName').val());
    var authorInfo = sanitize($('#addAuthorModal #authorInfo').val());
    var authorBiography = sanitize($('#addAuthorModal #authorBiography').val());
    if (authorFirstName != '' && authorLastName != '') {
        var url = "queryExecute.php?type=insert";
        var type = "POST";
        var data = 'query=Insert into `tbl_author` values (null,"' + authorFirstName + '","' + authorLastName + '","' + authorInfo + '","' + authorBiography + '")';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
                $('#defaultModal').modal('show');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }

        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$('#btnEditAuthor').click(function () {
    var authorID = $('#btnEditAuthor').attr('authorid');

    var authorFirstName = sanitize($('#editAuthorModal #authorFirstName').val());
    var authorLastName = sanitize($('#editAuthorModal #authorLastName').val());
    var authorInfo = sanitize($('#editAuthorModal #authorInfo').val());
    var authorBiography = sanitize($('#editAuthorModal #authorBiography').val());
    if (authorFirstName != '' && authorLastName != '') {
        var url = "queryExecute.php?type=update";
        var type = "POST";
        var data = 'query=Update `tbl_author` set  author_first_name = "' + authorFirstName + '", author_last_name="' + authorLastName + '", authorInformation = "' + authorInfo + '", authorBiography ="' + authorBiography + '" where authorID = "' + authorID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }

        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$('#btnAddPublisher').click(function () {
    var publisherName = sanitize($('#addPublisherModal #publisherName').val());
    var publisherAddress = sanitize($('#addPublisherModal #publisherAddress').val());
    var publisherWebsite = sanitize($('#addPublisherModal #publisherWebsite').val());
    var publisherDetail = sanitize($('#addPublisherModal #publisherDetail').val());
    var publisherCountry = sanitize($('#addPublisherModal #publisherCountry').val());
    if (publisherName != '') {
        var url = "queryExecute.php?type=insert";
        var type = "POST";
        var data = 'query=Insert into `tbl_publisher` values (null,"' + publisherName + '","' + publisherAddress + '","' + publisherWebsite + '","' + publisherDetail + '","' + publisherCountry + '")';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
                $('#defaultModal').modal('show');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }

        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$('#btnEditPublisher').click(function () {
    var publisherID = $('#editPublisherModal #btnEditPublisher').attr("publisherid");
    var publisherName = sanitize($('#editPublisherModal #publisherName').val());
    var publisherAddress = sanitize($('#editPublisherModal #publisherAddress').val());
    var publisherWebsite = sanitize($('#editPublisherModal #publisherWebsite').val());
    var publisherDetail = sanitize($('#editPublisherModal #publisherDetail').val());
    var publisherCountry = sanitize($('#editPublisherModal #publisherCountry').val());

    if (publisherName != '') {
        var url = "queryExecute.php?type=update";
        var type = "POST";
        var data = 'query=Update `tbl_publisher` set publisherName = "' + publisherName + '", publisherAddress ="' + publisherAddress + '", publisherWebsite = "' + publisherWebsite + '",publisherDetail="' + publisherDetail + '",publisherCountry="' + publisherCountry + '" where publisherID = "' + publisherID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }

        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$('#btnAddLocation').click(function () {
    var locationName = sanitize($('#addLocationModal #locationName').val());
    var subLocation = sanitize($('#addLocationModal #subLocation').val());
    var locationDesc = sanitize($('#addLocationModal #locationDesc').val());
    if (locationName != '' && subLocation != '') {
        var url = "queryExecute.php?type=insert";
        var type = "POST";
        var data = 'query=Insert into `tbl_location` values (null,"' + locationName + '","' + subLocation + '","' + locationDesc + '")';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
                $('#defaultModal').modal('show');
                loadLocationList();
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }
        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});
$('#btnEditLocation').click(function () {
    var locationID = $('#editLocationModal #btnEditLocation').attr('locationid');
    var locationName = sanitize($('#editLocationModal #locationName').val());
    var subLocation = sanitize($('#editLocationModal #subLocation').val());
    var locationDesc = sanitize($('#editLocationModal #locationDesc').val());
    if (locationName != '' && subLocation != '') {
        var url = "queryExecute.php?type=update";
        var type = "POST";
        var data = 'query=Update `tbl_location`  set locationName = "' + locationName + '", sublocation = "' + subLocation + '", locationDescription = "' + locationDesc + '" where locationID = "' + locationID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }
        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$(".modal").on('hidden.bs.modal', function () {
    $('.hiddenAlert').css('visibility', 'hidden');
});
$('#btnAddCategory').click(function () {
    var categoryName = sanitize($('#addCategoryModal #categoryName').val());
    var categoryDesc = sanitize($('#addCategoryModal #categoryDesc').val());
    if (categoryName != '' && categoryDesc != '') {
        var url = "queryExecute.php?type=insert";
        var type = "POST";
        var data = 'query=Insert into `tbl_category` (categoryName,categoryDescription) values ("' + categoryName + '","' + categoryDesc + '")';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                loadCategoryList();
                $('.modal').modal('hide');
                $('#defaultModal').modal('show');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }
        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$('#btnEditCategory').click(function () {

    var categoryID = $('#btnEditCategory').attr('categoryid');
    var categoryName = sanitize($('#editCategoryModal  #categoryName').val());
    var categoryDesc = sanitize($('#editCategoryModal  #categoryDesc').val());

    if (categoryName != '' && categoryDesc != '') {
        var url = "queryExecute.php?type=update";
        var type = "POST";
        var data = 'query=Update `tbl_category` set categoryName = "' + categoryName + '" ,categoryDescription = "' + categoryDesc + '" where categoryID = "' + categoryID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result == 'true') {
                $('.modal').modal('hide');
            } else {
                $('.modal').modal('hide');
                errorCallBack();
            }
        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

function resetModal() {
    $('.resetModal').val('');
}

function loadCategoryList(selected) {

    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=select * from tbl_category';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            var tempHtml = '';
            var rs = JSON.parse(result);
            tempHtml += '<option selected="" value="">Select Category</option>';
            for (var i = 0; i < rs.length; i++) {
                var categoryName = rs[i].categoryName;
                var categoryID = rs[i].categoryID;
                if (categoryID == selected) {
                    tempHtml += '<option value="' + categoryID + '" selected >' + categoryName + '</option>';
                    $('#categoryText').val(categoryName);
                    continue;
                }
                tempHtml += '<option value="' + categoryID + '" >' + categoryName + '</option>';

            }

            $('#categorySelect').html(tempHtml);
        } else {

        }
    }, errorCallBack);
}
$('#categorySelect').on('change', function () {
    $('#categorySelect').attr("value", $(this).val());
});
function loadLocationList(selected) {
    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=select `locationID`,`locationName`,`subLocation` from tbl_location';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {

            var tempHtml = '';
            tempHtml += '<option  selected="" value="" >Select Location</option>';
            var rs = JSON.parse(result);
            for (var i = 0; i < rs.length; i++) {
                var locationID = rs[i].locationID;
                var locationName = rs[i].locationName;
                var subLocation = rs[i].subLocation;
                if (locationID == selected) {
                    tempHtml += '<option value="' + locationID + '" selected>' + locationName + ' ' + subLocation + '</option>';
                    continue;
                }
                tempHtml += '<option value="' + locationID + '">' + locationName + ' ' + subLocation + '</option>';
            }

            $('#locationSelect').html(tempHtml);
        } else {

        }
    }, errorCallBack);
}

$('#locationSelect').on('change', function () {
    $('#locationSelect').attr("value", $(this).val());
});

function errorFetchBookInfo() {
    alert('Some error occured while obtaining information.')
    $('#isbnModal').modal('hide');
}

$('#addSwiftDialog').click(function () {

    var isbn = $('#isbnNumber').val();
    if (isbn.length == 13 || isbn.length == 10) {
        smartAdd = true;
        var url = "https://www.googleapis.com/books/v1/volumes?q=isbn:" + isbn + "&key=AIzaSyCrwJbqOVo9YKnkPUc_rZR-kW4wtKPhAH8";
        var type = "GET";
        var data = '';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result != '' && checkObj(result)) {

                if (checkObj(result.items)) {
                    var bookInfo = result.items[0];
                    if (checkObj(bookInfo)) {
                        var title = checkVal(bookInfo.volumeInfo.title);
                        if (checkObj(bookInfo.volumeInfo.authors)) {
                            var authorName = bookInfo.volumeInfo.authors[0].split(' ');
                            var authorFname = checkVal(authorName[0]);
                            var authorLname = checkVal(authorName[1]);
                            if (checkObj(authorName[2])) {
                                authorLname += " " + authorName[2];
                            }
                            $('#inputAuthorID').val('0');
                        }
                        var publisher = checkVal(bookInfo.volumeInfo.publisher);
                        $('#inputPublishID').val('0');
                        var publishedDate = checkVal(bookInfo.volumeInfo.publishedDate);
                        var description = checkVal(bookInfo.volumeInfo.description);
                        var ISBN10 = '';
                        var ISBN13 = '';
                        if (checkObj(bookInfo.volumeInfo.industryIdentifiers)) {
                            var typeOfIndexZero = bookInfo.volumeInfo.industryIdentifiers[0];
                            var typeofIndexOne = bookInfo.volumeInfo.industryIdentifiers[1];
                            if (typeOfIndexZero.type.indexOf('10') > -1) {
                                ISBN10 = typeOfIndexZero.identifier;
                            } else {
                                ISBN13 = typeOfIndexZero.identifier;
                            }

                            if (typeofIndexOne.type.indexOf('10') > -1) {
                                ISBN10 = typeofIndexOne.identifier;
                            } else {
                                ISBN13 = typeofIndexOne.identifier;
                            }


                        }
                        var pageCount = checkVal(bookInfo.volumeInfo.pageCount);
                        if (checkObj(bookInfo.volumeInfo.categories)) {
                            var category = checkVal(bookInfo.volumeInfo.categories[0]);
                        }
                        var imageLink = checkVal(bookInfo.volumeInfo.imageLinks && bookInfo.volumeInfo.imageLinks.thumbnail);
                        var language = checkVal(bookInfo.volumeInfo.language);

                        if (imageLink == '') {
                            $('#bookCover').attr('src', '');
                        } else {
                            $('#bookCover').attr('src', imageLink);
                            $('#imageSource').attr('value', imageLink);
                        }

                        $('#isbnModal').modal('hide');
                        $('#titleBox').val(title);
                        $('#ISBN10Box').val(ISBN10);
                        $('#ISBN13Box').val(ISBN13);
                        $('#descriptionBox').val(description);
                        if (category != '') {
                            $('#categorySelect').append('<option selected="selected" value="0">' + category + '</option');

                            $('#categorySelect').change();

                        }
                        $('#authorSelect').val(authorFname + " " + authorLname);
                        $('#yearBox').val(publishedDate);
                        $('#publisherSelect').val(publisher);
                        $('#languageBox').val(language);
                        $('#pagecountBox').val(pageCount);
                        $('#pageCount').val(language);
                    } else {
                        errorFetchBookInfo();
                    }
                } else {
                    errorFetchBookInfo();
                }
            } else {
                errorFetchBookInfo();
            }
        }, errorCallBack);
    } else {
        $('.hiddenAlert').css('visibility', 'visible');
    }
});

$('#librarianSwfitAdd').click(function () {

    localStorage.setItem("mainPageSwiftAdd", "true");
    window.location.href = "AddBooks.php";
});

$('.memberCirculate').click(function () {
    var mID = $(this).attr('memberid');
    localStorage.setItem("memberCirculate", "" + mID);

    window.location.href = "circulation.php";
});

$('.bookCirculate').click(function () {
    var bID = $(this).attr('bookid');

    localStorage.setItem("bookCirculate", "" + bID);
    window.location.href = "circulation.php";
});


$('#addSwift').click(function () {
    resetModal();
    $('#isbnModal').modal('show');
});

$('#categorySelect').on('change', function () {
    $('#categoryText').attr("value", $('#categorySelect option:selected').text());
});


$('#statusConfirmationChange').on('click', function () {
    var memberId = $(this).attr('memberid');
    var memberType = $(this).attr('memberType');
    var query = '';
    if (memberType == 'active') {
        query += 'Update tbl_user set active = 1 where user_id =' + memberId;
    } else {
        query += 'Update tbl_user set active = 0 where user_id =' + memberId;
    }
    var url = "queryExecute.php?type=update";
    var type = "POST";
    var data = 'query=' + query;
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            $('#statusConfirmation').modal("hide");
        } else {
            $('#statusConfirmation').modal("hide");
            errorCallBack();
        }
    }, errorCallBack);

});

$('#btnCirculate').click(function () {
    $('#circulateModal').modal('show');
});

$('#btnAddCirculation').click(function () {

    var bookID = $('#bookID').val();
    var memberID = $('#memberID').val();
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();

    var issuedDate = year + "-" + month + "-" + day;
    var returnDate = $('#returnDate').val();

    var status = "Issued";
    if (bookID == '' || memberID == '' || returnDate == '') {
        $('.hiddenAlert').css('visibility', 'visible');
        return;
    }
    var url = "queryExecute.php?type=insert";
    var type = "POST";
    var data = 'query=Insert into `tbl_circulation` values (null,"' + issuedDate + '","' + bookID + '","' + memberID + '","' + status + '","","","' + returnDate + '")';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            decreaseCount(bookID);
        } else {
            $('#circulateModalerror').text("Invalid Information or no more copies left.").css('visibility', 'visible');
        }
    }, errorCallBack);

});

function decreaseCount(bookID) {
    var bookID = bookID;
    var url = "queryExecute.php?type=update";
    var type = "POST";
    var plus = encodeURIComponent("+");
    var data = 'query=Update `tbl_books` set  bookedcopies = bookedcopies ' + plus + ' 1 where bookID = ' + bookID + ' ';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            $('#circulateModal').modal("hide");
        }
    }, errorCallBack);
}

$('#btnReturn').click(function () {
    $('#returnModal').modal("show");
});

$('#btnReturnBook').click(function () {

    var circulationID = $('#circulationText').val();
    var remarkText = $('#remarkText').val();
    var status = "Returned";
    var currentDate = new Date()
    var day = currentDate.getDate()
    var month = currentDate.getMonth() + 1
    var year = currentDate.getFullYear()

    var returnDate = year + "-" + month + "-" + day;

    if (circulationID == '') {
        $('.hiddenAlert').css('visibility', 'visible');
        return;
    }
    var url = "queryExecute.php?type=update";
    var type = "POST";
    var data = 'query=Update `tbl_circulation` set remark = "' + remarkText + '",returnDate = "' + returnDate + '", status = "' + status + '" where circulationID = "' + circulationID + '" and status="Issued"';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            increaseCount(circulationID);
        } else {
            $('#returnModalerror').text("Invalid Information.").css('visibility', 'visible');
        }
    }, errorCallBack);

});

function increaseCount(cID) {
    var circulationID = cID;

    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=Select bookID from `tbl_circulation` where circulationID = ' + circulationID + ' ';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            var rs = JSON.parse(result);
            var bookPartID = rs[0].bookID;
            var url = "queryExecute.php?type=update";
            var type = "POST";
            var data = 'query=Update `tbl_books` set  bookedcopies = bookedcopies - 1 where bookID = ' + bookPartID + ' ';
            var async = true;
            handleAjaxCall(url, type, data, async, function (result) {
                if (result !== 'false' && result.length > 0) {
                    $('#returnModal').modal("hide");
                }
            }, errorCallBack);
        }
    }, errorCallBack);

}
$('#memberID,#memberEditId').on('blur', function () {
    var memberID = $(this).val();
    if (memberID != '') {
        var url = "queryExecute.php?type=select";
        var type = "POST";
        var data = 'query=select user_id,user_first_name, user_last_name from  tbl_user u where user_id= "' + memberID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result !== 'false' && result.length > 0) {
                var rs = JSON.parse(result);
                var userid = rs[0].user_id;
                var firstName = rs[0].user_first_name;
                var lastName = rs[0].user_last_name;
                $('#memberInfo').text(userid + " - " + firstName + " " + lastName);

            } else {
                $('#memberInfo').text("No such record.");
            }
        }, function () {
            $('#memberInfo').text("No such record.");

        });
    }
});

$('#memberID,#bookID,#circulationInfo,#memberEditId').on('focus', function () {
    $(this).next('span').text("");
});

$('#bookID,#bookEditId').on('blur', function () {
    var bookID = $(this).val();
    if (bookID != '') {
        var url = "queryExecute.php?type=select";
        var type = "POST";
        var data = 'query=select b.bookID,b.title,b.totalcopies,b.bookedcopies from  tbl_books b  where b.bookID = "' + bookID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result !== 'false' && result.length > 0) {
                var rs = JSON.parse(result);
                var bookids = rs[0].bookID;
                var bookTitle = rs[0].title;
                var tcopies = rs[0].totalcopies;
                var bcopies = rs[0].bookedcopies;
                if (tcopies > bcopies) {
                    $('#booksInfo').text(bookids + " - " + bookTitle);
                    $('#btnAddCirculation').removeAttr('disabled');
                } else {
                    $('#booksInfo').text("No copies remaining!!!");
                    $('#btnAddCirculation').attr('disabled', 'disabled');
                }
            } else {
                $('#btnAddCirculation').removeAttr('disabled');
                $('#booksInfo').text("No such record.");
            }
        }, function () {
            $('#booksInfo').text("No such record.");
        });
    }

});

$('#circulationText').on('blur', function () {
    var circulationID = $(this).val();
    if (circulationID != '') {
        var url = "queryExecute.php?type=select";
        var type = "POST";
        var data = 'query=select b.bookID,b.title,u.user_id,u.user_first_name,u.user_last_name from  tbl_books b , tbl_circulation c, tbl_user u where c.bookID = b.bookID and c.memberID = u.user_id and c.circulationID = "' + circulationID + '"';
        var async = true;
        handleAjaxCall(url, type, data, async, function (result) {
            if (result !== 'false' && result.length > 0) {
                var rs = JSON.parse(result);
                var bookids = rs[0].bookID;
                var bookTitle = rs[0].title;
                var userid = rs[0].user_id;
                var firstName = rs[0].user_first_name;
                var lastName = rs[0].user_last_name;
                $('#circulationInfo').text("[" + bookids + " - " + bookTitle + "] return by [" + userid + " - " + firstName + " " + lastName + "]");
            } else {
                $('#circulationInfo').text("No such record.");
            }
        }, function () {
            $('#circulationInfo').text("No such record.");

        });
    }

});

function onReturnLink(value) {
    $('#returnModal').modal("show");
    $('#circulationText').val(value).blur();
}


$('#rItem').click(function () {
    localStorage.setItem("openR", "true");
    window.location.href = "circulation.php";
});

$('#cirItem').click(function () {
    localStorage.setItem("openC", "true");
    window.location.href = "circulation.php";
});

$('#viewItem').click(function () {
    window.location.href = "booksList.php"
});

function updateDivs() {
    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=select count(*) as counts from tbl_books';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            var rs = JSON.parse(result);
            var count = rs[0].counts;
            $('#numBook').text(count);
        }
    }, errorCallBack);

    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=select count(*) as counts from tbl_circulation';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            var rs = JSON.parse(result);
            var count = rs[0].counts;
            $('#numCirculate').text(count);
        }
    }, errorCallBack);

    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=select count(*) as counts from tbl_user';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            var rs = JSON.parse(result);
            var count = rs[0].counts;
            $('#numMember').text(count);
        }
    }, errorCallBack);

    var url = "queryExecute.php?type=select";
    var type = "POST";
    var data = 'query=select count(*) as counts from tbl_category';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            var rs = JSON.parse(result);
            var count = rs[0].counts;
            $('#numCategory').text(count);
        }
    }, errorCallBack);
}


$('#deleteBook').click(function () {
    var bookID = $(this).attr('bookid');
    var url = "queryExecute.php?type=delete";
    var type = "POST";
    var data = 'query=delete from `tbl_books` where bookID =' + bookID + '';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            $('#deleteBookModal').modal('hide');
        } else {
            errorCallBack();
        }
    }, errorCallBack);
});

$('#btnDeleteCategory').click(function () {
    var categoryId = $(this).attr('categoryid');

    var url = "queryExecute.php?type=delete";
    var type = "POST";
    var data = 'query=delete from `tbl_category` where categoryID = ' + categoryId + '';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            $('#deleteCategoryModal').modal('hide');
        } else {
            errorCallBack();
        }
    }, errorCallBack);
});

$('#deleteBtnPublisher').click(function () {
    var publisherID = $(this).attr('publisherid');

    var url = "queryExecute.php?type=delete";
    var type = "POST";
    var data = 'query=delete from `tbl_publisher` where publisherID = ' + publisherID + '';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            $('#deletePublisherModal').modal('hide');
        } else {
            errorCallBack();
        }
    }, errorCallBack);
});



$('#deleteBtnLocation').click(function () {
    var locationID = $(this).attr('locationid');

    var url = "queryExecute.php?type=delete";
    var type = "POST";
    var data = 'query=delete from `tbl_location` where locationID = ' + locationID + '';
    var async = true;
    handleAjaxCall(url, type, data, async, function (result) {
        if (result !== 'false' && result.length > 0) {
            $('#deleteLocationModal').modal('hide');
        } else {
            errorCallBack();
        }
    }, errorCallBack);
});

$('#searchBtn').click(function(){
    var keyword = sanitize($('#searchText').val());
   window.location.href = 'booksList.php?search='+keyword;
});
