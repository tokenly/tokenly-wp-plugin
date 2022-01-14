import * as React from 'react';

import { 
	Flex,
} from '@wordpress/components';

interface StatusIndicatorlProps {
	status: boolean;
}

export default function StatusIndicator( props: StatusIndicatorlProps ) {
	return (
		<Flex justify="flex-start" align="baseline" gap={ 0 } style={ { marginBottom: '8px' } }>
			<span>Status: </span>
			<span style={ { marginLeft: '5px' } }>
				<b>{ props?.status ? 'Connected' : 'Not Connected' }</b>
			</span>
			<span 
				className="tokenpass status-indicator"
				style={ {
					marginLeft: '10px',
					backgroundColor: props?.status ? 'rgb(135 211 82)' : '#d84315',
				} }>
			</span>
		</Flex>
	);
}
 

