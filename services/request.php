<?php

class UserMethod
{
    const add = "addUser";
    const update = "udpateUser";
    const delete = "deleteUser";
    const listAll = "listAllUser";
    const listPage = "listPageUser";
    const listOne = "listOneUser";
    const changePassword = "changePassword";
}

class Message
{
    const methodNotFound = "Method not found!";
    const noAuthorize = "You have no authorize";
    const noToken = "You have no token";
    const wrongUserAndPass = "Wrong username and password!";
    const wrongUser = "Wrong username!";
    const wrongPass = "Wrong password!";
    const userEmpty = "Username is empty!";
    const passEmpty = "Password is empty!";
    const emptyUserAndPass = "Username and password are empty!";
    const loginOk = "Login Successfully!";


    const addSuccess = "Add Data Successfully.";
    const addFail = "Add Data Fail!";
    const updateSuccess = "Update data successfully.";
    const updateFail = "Update data fail!";
    const deleteSuccess = "Delete data successfully.";
    const deleteFail = "Delete data fail!";
    const changePasswordSuccess = "Change Password Successfully.";
    const changePasswordFail = "Change Password Fail!";


    const listAll = "Data list all";
    const listPage = "Data list page";
    const listOne = "Data list one";


    const empty = " is empty!";
    const already = " already exists!";
    const exists = " is not exists!";
    const date = " is not date format!";
    const time = " is not time format!";
    const dateTime = " is not date time format!";
    const number = " is number only!";
    const notEqual = " is not equal";
}
