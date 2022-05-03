<?php


function renderView(string $layout, string $view = '', array $options = [], array $data = [])
{

  return view(
    '/layouts/' . $layout,
    [
        'content' => view( $view, $data),
        'options' => $options
    ],
  );

}
