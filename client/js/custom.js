/**
 * 比较函数生成器
 * 
 * @param iCol
 *            数据行数
 * @param sDataType
 *            该行的数据类型
 * @return
 */
function  generateCompareTRs(iCol, sDataType) {
     return   function  compareTRs(oTR1, oTR2) {
        vValue1 = convert(oTR1.cells[iCol].firstChild.nodeValue, sDataType);
        vValue2 = convert(oTR2.cells[iCol].firstChild.nodeValue, sDataType);
         if  (vValue1 < vValue2) {
             return  -1;
        }  else   if  (vValue1 > vValue2) {
             return  1;
        }  else  {
             return  0;
        }
    };
}
/**
 * 处理排序的字段类型
 * 
 * @param sValue
 *            字段值 默认为字符类型即比较ASCII码
 * @param sDataType
 *            字段类型 对于date只支持格式为mm/dd/yyyy或mmmm dd,yyyy(January 12,2004)
 * @return
 */
function  convert(sValue, sDataType) {
     switch  (sDataType) {
     case   "int" :
         return  parseInt(sValue);
     case   "float" :
         return  parseFloat(sValue);
     case   "date" :
         return   new  Date(Date.parse(sValue));
     default :
         return  sValue.toString();
    }
}
/**
 * 通过表头对表列进行排序
 * 
 * @param sTableID
 *            要处理的表ID<table id=''>
 * @param iCol
 *            字段列id eg: 0 1 2 3 ...
 * @param sDataType
 *            该字段数据类型 int,float,date 缺省情况下当字符串处理
 */
function  sortTable(sTableID, iCol, sDataType) {
     var  oTable = document.getElementById(sTableID);
     var  oTBody = oTable.tBodies[0];
     var  colDataRows = oTBody.rows;
     var  aTRs =  new  Array;
     for  (  var  i = 0; i < colDataRows.length; i++) {
        aTRs[i] = colDataRows[i];
    }
     if  (oTable.sortCol == iCol) {
        aTRs.reverse();
    }  else  {
        aTRs.sort(generateCompareTRs(iCol, sDataType));
    }
     var  oFragment = document.createDocumentFragment();
     for  (  var  j = 0; j < aTRs.length; j++) {
        oFragment.appendChild(aTRs[j]);
    }
    oTBody.appendChild(oFragment);
    oTable.sortCol = iCol;
}