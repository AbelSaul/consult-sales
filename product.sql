SELECT
    productos.idproducto, productos.codigo, productos.codigo2, productos.moneda , productos.tipo , productos.tipo_imp, productos.descripcion , productos.precio, productos.precio1, productos.precio2, productos.precio3, productos.precio4, productos.precio_fra , productos.medida, productos.medida_fra, productos.fraccion, productos.igv, productos.marca  , productos.codigo, productos.descripcion,
    kardex.idlocal, SUM(entrada)-SUM(salida) as stock,
    (SELECT SUM(cantidad)-SUM(canjeado) as reserva
    FROM det_pro
    WHERE det_pro.idproducto=productos.idproducto
    GROUP BY det_pro.idproducto) as reserva,

    ((SUM(entrada)-SUM(salida)) - ((
                                SELECT SUM(cantidad)-SUM(canjeado) as reserva
    FROM det_pro
    WHERE det_pro.idproducto=productos.idproducto
    GROUP BY det_pro.idproducto))) as disponible
FROM productos
    LEFT JOIN kardex ON productos.idproducto=kardex.idproducto
    LEFT JOIN det_pro ON productos.idproducto=det_pro.idproducto
WHERE (productos.idlocal=1 OR productos.idlocal=0) AND (kardex.idlocal=1 or kardex.idlocal IS NULL) AND productos.estado='A' AND (YEAR(kardex.fecha)=2019 OR YEAR(kardex.fecha) IS NULL)

GROUP BY productos.idproducto
ORDER BY productos.descripcion
