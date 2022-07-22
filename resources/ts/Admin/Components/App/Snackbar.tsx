import * as React from 'react'

import { 
	Animate,
	Snackbar,
} from '@wordpress/components'

interface SnackbarProps {
	children?: any
	show?: boolean
}

export default function AppSnackbar( props: SnackbarProps ) {
	return (
		<div style={ {
			position: 'fixed',
			bottom: 0,
			left: '50%',
			transform: 'translateX(-50%)',
			zIndex: 999
		} }>
			<div style={{ opacity: props.show ? 1 : 0, transform: `translateY( ${ props.show ? '-24px' : 0 } )`, transition: 'all 0.2s' }}>
			<Snackbar>{ props?.children }</Snackbar>
			</div>
		</div>
	)
}
