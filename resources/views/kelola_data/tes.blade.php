<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Organization Chart</title>
    <style>
        /* CSS */
        html,
        body {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            overflow: hidden;
            font-family: Helvetica, sans-serif;
        }

        #tree {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <script src="https://balkan.app/js/OrgChart.js" defer></script>
    <div id="tree"></div>

    <script>
        // JavaScript
        var chart = new OrgChart(document.getElementById("tree"), {
            template: "base",
            mouseScroll: OrgChart.action.none,
            enableSearch: false,
            nodeBinding: {
                img_0: "img",
                field_0: "name",
                field_1: "title"
            },
            nodes: [
                {
                    id: 1,
                    name: "Amber McKenzie",
                    title: "CEO",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 2,
                    pid: 1,
                    name: "Ava Field",
                    title: "IT Manager",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 3,
                    pid: 1,
                    name: "Rhys Harper",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 4,
                    pid: 3,
                    name: "Amber McKenzie",
                    title: "CEO",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 5,
                    pid: 3,
                    name: "Ava Field",
                    title: "IT Manager",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 6,
                    pid: 3,
                    name: "Rhys Harper",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 7,
                    name: "Amber McKenzie",
                    title: "CEO",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 8,
                    pid: 1,
                    name: "Ava Field",
                    title: "IT Manager",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 9,
                    pid: 1,
                    name: "Rhys Harper",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 10,
                    pid: 3,
                    name: "Amber McKenzie",
                    title: "CEO",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 11,
                    pid: 3,
                    name: "Ava Field",
                    title: "IT Manager",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                },
                {
                    id: 12,
                    pid: 3,
                    name: "Rhys Harper",
                    img: "https://cdn.balkan.app/shared/empty-img-none.svg"
                }
            ]
        });
    </script>
</body>

</html>
