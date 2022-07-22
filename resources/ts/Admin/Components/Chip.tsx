import * as React from 'react'

interface ChipProps {
	children: any
	status: string
}

export default function Chip( props: ChipProps ) {
	function getClassName(): string {
		let name = 'tokenly-component-chip'
		if ( props.status ) {
			name += ' ' + props.status
		}
		return name
	}

	return (
		<span>
			<span className={ getClassName() }>{ props.children }</span>
		</span>
	)
}
