@extends('layouts.show',[
    'items' => $subject,
    'edit_route' => route('subject.edit',$subject->id),
    'delete_route' => route('subject.destroy',$subject->id),
    ])
