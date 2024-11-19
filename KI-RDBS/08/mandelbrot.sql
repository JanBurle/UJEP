-- Step 1: Create a table to store the Mandelbrot set results
CREATE TABLE mandelbrot (
    x INT,
    y INT,
    iter INT
);

-- Step 2: Use a CTE to calculate the Mandelbrot set
WITH RECURSIVE mandelbrot_cte(x, y, zx, zy, iter) AS (
    -- Initial values
    SELECT
        x,
        y,
        0.0::double precision AS zx,
        0.0::double precision AS zy,
        0 AS iter
    FROM generate_series(-1000, 1000) AS x,
         generate_series(-1000, 1000) AS y

    UNION ALL

    -- Recursive calculation
    SELECT
        m.x,
        m.y,
        m.zx * m.zx - m.zy * m.zy + (m.x / 500.0)::double precision AS zx,
        2 * m.zx * m.zy + (m.y / 500.0)::double precision AS zy,
        m.iter + 1
    FROM mandelbrot_cte m
    WHERE m.iter < 1000 AND (m.zx * m.zx + m.zy * m.zy) < 4.0
)

-- Step 3: Insert the results into the table
INSERT INTO mandelbrot (x, y, iter)
SELECT x, y, MAX(iter) AS iter
FROM mandelbrot_cte
GROUP BY x, y;


---------------

WITH RECURSIVE
x(i)
AS (
    VALUES(0)
UNION ALL
    SELECT i + 1 FROM x WHERE i < 101
),
Z(Ix, Iy, Cx, Cy, X, Y, I)
AS (
    SELECT Ix, Iy, X::float, Y::float, X::float, Y::float, 0
    FROM
        (SELECT -2.2 + 0.031 * i, i FROM x) AS xgen(x,ix)
    CROSS JOIN
        (SELECT -1.5 + 0.031 * i, i FROM x) AS ygen(y,iy)
    UNION ALL
    SELECT Ix, Iy, Cx, Cy, X * X - Y * Y + Cx AS X, Y * X * 2 + Cy, I + 1
    FROM Z
    WHERE X * X + Y * Y < 16.0
    AND I < 27
),
Zt (Ix, Iy, I) AS (
    SELECT Ix, Iy, MAX(I) AS I
    FROM Z
    GROUP BY Iy, Ix
    ORDER BY Iy, Ix
)
SELECT array_to_string(
    array_agg(
        SUBSTRING(
            ' .,,,-----++++%%%%@@@@#### ',
            GREATEST(I,1),
            1
        )
    ),''
)
FROM Zt
GROUP BY Iy
ORDER BY Iy;
