import * as React from 'react'

import { 
	Flex,
	Dashicon,
} from '@wordpress/components'

interface AddressStatusProps {
	address: any
}

export default function AddressStatus( props: AddressStatusProps ) {
	return (
		<Flex
            justify="flex-start"
            style={{display: 'inline-flex', flexGrow: 0, flexShrink: 1}}
        >
            <span title={ props?.address?.verified ? 'Verified' : 'Not Verified' } style={ { display: 'inline-flex', alignItems: 'center' } }>
                <Dashicon style={ { width: '16px', height: '16px', fontSize: '16px' } } icon={ props?.address?.verified ? 'yes' : 'no' } />
            </span>
            { props?.address?.isSource == true &&
                <span title="Is Source" style={{display: 'inline-flex', alignItems: 'center'}}>
                    <Dashicon style={ { width: '16px', height: '16px', fontSize: '16px' } } icon="update" />
                </span>
            }
		</Flex>
	)
}
 



