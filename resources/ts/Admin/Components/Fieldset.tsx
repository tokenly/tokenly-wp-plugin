import * as React from 'react';

interface ConnectionInfoProps {
	label?: string;
	help?: string;
	children: any;
}

export default function ConnectionInfo( props: ConnectionInfoProps ) {
	return (
		<fieldset style={ { border: '1px solid #dcdcde', padding: '12px' } }>
			<legend style={{ fontSize: '13px' }}>{ props.label }</legend>
			<div>{ props.help } </div>
			{ props.children }
		</fieldset>
	);
}
