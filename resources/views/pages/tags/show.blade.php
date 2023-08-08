@extends('layouts.show',[
    'items' => $tag,
    'edit_route' => route('tag.edit',$tag->id),
    'delete_route' => route('tag.destroy',$tag->id),
    ])
