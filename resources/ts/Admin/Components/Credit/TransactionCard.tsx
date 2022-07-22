import * as React from 'react'
import * as dayjs from 'dayjs'
import TransactionInfo from './TransactionInfo'
import TransactionLink from './TransactionLink'

import { 
	Card,
	CardHeader,
	CardBody,
} from '@wordpress/components'

interface TransactionCardProps {
	transaction: any
}

export default function TransactionCard( props: TransactionCardProps ) {
	return (
		<Card size="extraSmall" style={ { width: '100%' } }>
			<CardHeader>
				<TransactionLink uuid={ props.transaction?.txUuid } />
			</CardHeader>
			<CardBody style={ { width: '100%' } }>
				<TransactionInfo transaction={ props.transaction } />
			</CardBody>
		</Card>
	)
}
 

