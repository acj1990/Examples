export default function DetailCard({ title, list }) {
    let headAppend = "";

    function Header(col, i) {
        return <span key={i} className="font-bold text-lg">{col[1]}</span>;
    }
    
    function HeadRow(row, i) {
        return Object.keys(row).map((key) => [key, row[key]]).map((col, i) => Header(col, i));
    }

    function Col(col, i) {
        return <span key={i} className="">{col[1]}</span>;
    }
    
    function Row(row, i) {
        return Object.keys(row[1]).map((key) => [key, row[1][key]]).map((col, i) => Col(col, i));
    }

    function Table() {
        if (headAppend.length == 0 && typeof(list[0]) == "object") {
            headAppend = HeadRow(Object.keys(list[0]));
        }

        return <div className={"grid bg-gray-700 card-body text-gray-900 dark:text-gray-400 text-xs pb-7 pl-2 grid-cols-" + Object.keys(list[0]).length}>{headAppend}{Object.keys(list).map((key) => [key, list[key]]).map((row, i) => Row(row, i))}</div>;
    }

    return (
        <div className="m-3 col-span-5 max-w-100 content-start bg-white dark:bg-gray-500 overflow-hidden shadow-xl rounded-md">
            <div className="p-1 text-gray-900 dark:text-gray-100 text-center font-bold">{title}</div>
            <Table />
        </div>
    );
}