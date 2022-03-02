import * as React from 'react';

interface Row {
	label: string;
	component: JSX.Element;
}

interface FormTableProps {
	rows: Array<Row>;
}

export default function FormTable( props: FormTableProps ) {
	const rows = props.rows.map( ( row: Row ) => {
		return (
			<tr className="form-field">
				<th>{ row.label }</th>
				<td>{ row.component }</td>
			</tr>
		);
	} );
	return (
		<table className="form-table" style={ { maxWidth: '800px' } }>
			<tbody>
				{ rows }
			</tbody>
		</table>
	);
}
